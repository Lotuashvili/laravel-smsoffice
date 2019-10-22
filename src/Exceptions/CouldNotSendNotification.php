<?php

namespace Lotuashvili\LaravelSmsOffice\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * Thrown when the given phone number is invalid
     *
     * @return static
     */
    public static function invalidNumber()
    {
        return new static('Phone number is invalid');
    }

    /**
     * Thrown when there is no number provided
     *
     * @return static
     */
    public static function numberNotProvided()
    {
        return new static('Phone number is not provided');
    }

    /**
     * Thrown when there is no api key provided
     *
     * @return static
     */
    public static function apiKeyNotProvided()
    {
        return new static('API key is not provided');
    }

    /**
     * Thrown when there is no sender provided
     *
     * @return static
     */
    public static function senderNotProvided()
    {
        return new static('Sender is not provided');
    }
}
