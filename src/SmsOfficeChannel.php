<?php

namespace Lotuashvili\LaravelSmsOffice;

use Illuminate\Notifications\Notification;
use Lotuashvili\LaravelSmsOffice\Exceptions\CouldNotSendNotification;

class SmsOfficeChannel
{
    protected $sms;

    protected $routeName = 'Sms';

    /**
     * SMSChannel constructor.
     *
     * @param SmsOffice $sms
     */
    public function __construct(SmsOffice $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        if (!$to = $notifiable->routeNotificationFor($this->routeName)) {
            throw CouldNotSendNotification::numberNotProvided();
        }

        if (is_array($message)) {
            $reference = data_get($message, 'reference');
            $message = data_get($message, 'message');
        }

        $this->sms->send($to, $message, $reference ?? null, $notifiable);
    }
}
