<?php

namespace Salex\SMS\Traits;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Core\Repositories\CoreConfigRepository;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Twilio\Rest\Client as TwilioClient;


use Illuminate\Support\Facades\Log;
use Salex\SMS\Repositories\SMSRepository;

trait Sender
{
    // public static $configShouldSendKey = 'sms.general.notifications.new-order';

    public $smsProviderNo = 2;

    public $client;

    public function __construct(
        protected SMSRepository $sMSRepository,
        protected CoreConfigRepository $coreConfigRepository
    ) {
    }

    private function isPhoneValid($phone): bool
    {
        return preg_match('/^[0-9]{10}+$/', $phone);
    }

    private function getConfigVal($key, $default = '')
    {
        $coreConfig = $this->coreConfigRepository->findOneByField('code', $key);

        if ($coreConfig) {
            /** @var CoreConfig $coreConfig */
            return $coreConfig->getAttribute('value');
        }

        return config('app.' . $key, $default);
    }


    private function shouldSendSMS(): ?bool
    {
        return $this->getConfigVal($this->configShouldSendKey, false);
    }


    public function getClient()
    {
        if ($this->smsProviderNo == 2) {
            $sid    = $this->getConfigVal('sms.twilio.config.sid');
            $token  = $this->getConfigVal('sms.twilio.config.token');
            $this->client = new TwilioClient($sid, $token);
            return $this->client;
        }

        $this->client = new Client([
            'base_uri' => 'https://gateway.sms77.io/api/sms',
            RequestOptions::HEADERS => [
                'X-Api-Key' => $this->getConfigVal('sms.sms77.config.api_key'),
            ],
        ]);
        return $this->client;
    }

    public function getSMSBalance()
    {
        if ($this->smsProviderNo == 2) {
            return $this->client->api->v2010->account->balance->fetch()->balance;
        }
        return $this->client->post(
            'balance',
            [RequestOptions::JSON => []]
        )->getBody()->getContents();
    }


    public function getGraph($params)
    {

        $graph = [];
        if ($this->smsProviderNo == 2) {
            $p = [
                'category' => 'sms',
                "startDate" => new \DateTime($params['start']),
                "endDate" => new \DateTime($params['end']),
            ];
            $lastMonth = $this->client->usage
                ->records
                ->daily
                ->read($p);
            foreach ($lastMonth as $key => $record) {
                $graph['label'][] = $record->endDate->format('d M');
                $graph['total'][] = $record->usage;
            }
            $graph['label'] = array_reverse($graph['label']);
            $graph['total'] = array_reverse($graph['total']);
            
        } else {
            $graphResult = $this->client->post(
                'analytics',
                [RequestOptions::JSON => $params]
            )->getBody()->getContents();

            $graphJson = json_decode($graphResult, true);

            foreach ($graphJson as $key => $value) {
                $graph['label'][] = $value['date'];
                $graph['total'][] = $value['sms'];
            }
        }

        return $graph;
    }


    public function sendSMS($event_key, $recipient, $message)
    {
        // $sendKey = static::$configShouldSendKey;
        // Log::info('Within Sender Class Currently', compact('apiKey'));
        // Log::info('Within Sender Class Currently', compact('sendKey'));
        //    if (!core()->getConfigData('customer.settings.email.verification')) {
        //     $shouldSend = $this->getSMSSendConfig();

        //     Log::info('Core Settings IS False Send SMS', compact('shouldSend'));
        //         return;
        //     }


        $phone = $recipient->phone;

        $smsParams = [
            'json' => true,
            'from' => $this->getConfigVal('sms.twilio.config.sender_id'),
            'text'  => $message,
            'to' => $phone,
            'recipient_user_id' => $recipient->id,
            'event_key' => $event_key,
        ];


        // if (!$this->isPhoneValid($phone)) {
        //     $smsParams['response'] = json_encode(['error' => __('sms::app.errors.invalid-phone-number')]);
        //     $smsParams['to'] = 'unknown';
        //     $sms = $this->sMSRepository->create($smsParams);
        //     return;
        // }

        $client = $this->getClient();

        Log::info('SMS Detials', compact('smsParams'));
        $sms = $this->sMSRepository->create($smsParams);


        try {
            if ($this->smsProviderNo == 2) {
                $msid = $this->getConfigVal('sms.twilio.config.ms_id');
                $response = $client->messages
                    ->create(
                        $phone, // to
                        [
                            "messagingServiceSid" => $msid,
                            "body" => $message
                        ]
                    );
                $sent = $response->status == 'sent';
                $sentPhone = $response->to;
                $balance = 'pending';
                $responseText = json_encode($response);
            } else {
                $responseText = $client->post(
                    'sms',
                    [RequestOptions::JSON => $smsParams]
                )->getBody()->getContents();


                $response = json_decode($responseText);
                $sent = $response->messages[0]->success;
                $sentPhone = $response->messages[0]->recipient;
                $balance = $response->balance;
            }

            $sms = $this->sMSRepository->find($sms->id);
            $sms->update([
                'response' => $responseText,
                'sent' => $sent,
                'phone' => $sentPhone,
            ]);

            if ($sent) {
                session()->flash('success', trans('sms::app.messages.sms-sent', ['balance' => $balance]));
            } else {
                session()->flash('error', trans('sms::app.messages.sms-not-sent', ['balance' => $balance]));
            }

            Log::info('SMS sent to SMS dispatch.', compact('responseText'));
        } catch (Exception $e) {
            session()->flash('error', trans('sms::app.messages.sms-not-sent', ['balance' => 'error']));
            $error = $e->getMessage();
            $errors[] = $error;
            Log::error('sms77 failed to send SMS.', compact('error'));
        }
    }
}
