<?php

namespace App\Handlers;

use App\Bots\Eve;
use App\Slack\Event;
use App\Slack\Message;

abstract class Handler
{
    /**
     * @var Eve
     */
    private $eve;

    /**
     * @param Eve $eve
     */
    public function __construct(Eve $eve)
    {
        $this->eve = $eve;
    }

    /**
     * @param Message $message
     */
    protected function send(Message $message)
    {
        $this->eve->send($message);
    }

    /**
     * @param Event $event
     */
    abstract public function canHandle(Event $event);

    /**
     * @param Event $event
     */
    abstract public function handle(Event $event);
}
