<?php

namespace Salex\Binance\Listeners;

use Salex\Binance\Payment\Binance;
use Webkul\Sales\Repositories\OrderTransactionRepository;

class Transaction
{
    /**
     * Create a new listener instance.
     *
     * @param  \Webkul\Paypal\Payment\SmartButton  $smartButton
     * @param  \Webkul\Sales\Repositories\OrderTransactionRepository  $orderTransactionRepository
     * @return void
     */
    public function __construct(
        protected Binance $binance,
        protected OrderTransactionRepository $orderTransactionRepository
    ) {
    }

    /**
     * Save the transaction data for online payment.
     * @param  \Webkul\Sales\Models\Invoice $invoice
     *
     * @return void
     */
    public function saveTransaction($invoice)
    {
        $data = request()->all();

        if ($invoice->order->payment->method == 'binance') {
            if (isset($data['orderData']) && isset($data['orderData']['orderID'])) {
                $binanceOrderId = $data['orderData']['orderID'];
                $transactionDetails = $this->binance->getOrder($binanceOrderId);
                $transactionDetails = json_decode(json_encode($transactionDetails), true);

                if ($transactionDetails['statusCode'] == 200) {
                    $transactionData['transaction_id'] = $transactionDetails['result']['id'];
                    $transactionData['status']         = $transactionDetails['result']['status'];
                    $transactionData['type']           = $transactionDetails['result']['intent'];
                    $transactionData['payment_method'] = $invoice->order->payment->method;
                    $transactionData['order_id']       = $invoice->order->id;
                    $transactionData['invoice_id']     = $invoice->id;
                    $transactionData['data']           = json_encode(
                        array_merge(
                            $transactionDetails['result']['purchase_units'],
                            $transactionDetails['result']['payer']
                        )
                    );

                    $this->orderTransactionRepository->create($transactionData);
                }
            }
        }
    }
}
