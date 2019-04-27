<?php

namespace Lotuashvili\LaravelSmsOffice;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Lotuashvili\LaravelSmsOffice\Events\SmsSent;
use Lotuashvili\LaravelSmsOffice\Exceptions\CouldNotSendNotification;

class SmsOffice
{
    const SEND_URL = 'http://smsoffice.ge/api/v2/send/?key=%s&destination=%s&sender=%s&content=%s&urgent=true';

    const BALANCE_URL = 'http://smsoffice.ge/api/getBalance?key=%s';

    protected $apiKey;

    protected $sender;

    protected $client;

    protected $driver;

    public function __construct()
    {
        $this->apiKey = config('smsoffice.key');
        $this->sender = config('smsoffice.sender');
        $this->driver = config('smsoffice.driver');

        $this->client = new Client();
    }

    public function send($to, $message, $reference = null, Model $model = null)
    {
        if ($this->driver === 'log') {
            return Log::info('SMSOFFICE: ' . $to . ' - ' . $message);
        }

        $this->checkParameters();

        if (substr($to, 0, 3) != '995') {
            $to = '995' . $to;
        }

        /*
         * Check if message contains UTF8 characters
         */
        if (strlen($message) !== strlen(utf8_decode($message))) {
            $message = rawurlencode($message);
        }

        $url = sprintf(self::SEND_URL, $this->apiKey, $to, $this->sender, $message);

        if ($reference) {
            $url .= '&reference=' . $reference;
        }

        $response = $this->client->request('GET', $url)->getBody()->getContents();

        event(new SmsSent($to, $message, $reference, $model));

        return $response;
    }

    public function balance()
    {
        $url = sprintf(self::BALANCE_URL, $this->apiKey);

        return (int) $this->client->request('GET', $url)->getBody()->getContents();
    }

    private function checkParameters()
    {
        if (empty($this->apiKey)) {
            throw CouldNotSendNotification::apiKeyNotProvided();
        }

        if (empty($this->sender)) {
            throw CouldNotSendNotification::senderNotProvided();
        }
    }
}
