<?php

return [
    'order-recieved-sms' => 'Guardar',
    'sms-sent-count' => 'Number of Sent SMS',
    'sms-failed-count' => 'Number of Failed SMS',
    'sms-balance' => 'SMS Balance Units',
    'recipient' => 'Recipient Number',
    'response' => 'Response',
    'event-key' => 'Event Key',
    'text' => 'Text Message',
    'sent' => 'Sent',
    'pending'=> 'Pending',
    'sms' => [
        'sms' => 'Text Messages',
        'send' => 'Send Message',
        'delete' => 'Delete Message'
    ],

    'sms77' => [

        'sender-id' => 'SMS77 Sender Name',
        'sender-id-tip' => 'From Name of SMS77',
        'settings' => 'SMS77 Provider Settings',
        'authentication' => 'SMS77 Authentication Settings',
        'api-key' => 'SMS77 API Key',
        'api-key-tip' => 'Gotten from SMS77 Account Portal',

    ],

    'twilio' => [

        'token' => 'Twilio Token ',
        'token-tip' => 'Twilio Account Token',
        'settings' => 'Twilio SMS Provider Settings',
        'authentication' => 'Twilio Authentication Settings',
        'sid' => 'Twilio SID Key',
        'sid-tip' => 'Gotten from Twilio Account Portal',
        'ms-id' => 'Twilio Messaging Service ID',
        'ms-id-tip' => 'Gotten from Twilio Account Portal',
    ],
    'notifications' => [
        'new-order' => 'Send a notification SMS after new order',
        'new-invoice' => 'Send a notification SMS after invoice is generated',
        'new-shipment' => 'Send a notification SMS for Shipment',
        'cancel-order' => 'Send a notification SMS when order is cancelled',

    ],
    'messages' => [
        'order-recieved' => 'Hi :first_name thank you for your order, Your Order has been placed and is :status. Your Order Id is :order_id. Item will be delivered soon.',
        'shipment-recieved' => 'Hi :first_name thank you for your order, Your Order Id is :order_id. Item will be delivered soon. Your Tracking Id is :tracking_id',
        'invoice-generated' => 'Hi :first_name thank you for your order, Invoice for :order_id of :total has been recieved. ',


        'sms-sent'=> 'Message Sent Successfully, balance is now :balance',
        'sms-not-sent'=> 'Message Sending Failed, balance is :balance',
        'no-api-key'=> 'No SMS77 API Key Found Please Set Key Here',
    ],

    'dashboard' => [
        'events' => 'SMS Events',
    ],

    'errors' => [
        'invalid-phone-number'=> 'Phone Number is Invalid'
    ]
];
