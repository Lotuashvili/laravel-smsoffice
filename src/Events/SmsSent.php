<?php

namespace Lotuashvili\LaravelSmsOffice\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class SmsSent
{
    use SerializesModels;

    /**
     * @var int
     */
    public $to;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var Model
     */
    public $model;

    /**
     * Create a new event instance.
     *
     * @param int $to
     * @param string $message
     * @param string|null $reference
     * @param Model|null $model
     */
    public function __construct(int $to, string $message, string $reference = null, Model $model = null)
    {
        $this->to = $to;
        $this->message = $message;
        $this->reference = $reference;
        $this->model = $model;
    }
}
