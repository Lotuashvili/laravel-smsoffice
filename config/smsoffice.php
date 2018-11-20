<?php

return [
    /**
     * API Key provided by SMSOffice
     */
    'key' => env('SMSOFFICE_API_KEY'),

    /**
     * Sender name
     * You have to register name on smsoffice.ge
     */
    'sender' => env('SMSOFFICE_SENDER'),

    /**
     * SMS Driver
     *
     * Supported: "log" and "sms"
     */
    'driver' => env('SMSOFFICE_DRIVER', 'sms'),
];
