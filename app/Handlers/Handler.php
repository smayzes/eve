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
    protected $eve;

    /**
     * @var bool
     */
    protected $stopPropagation = true;

    /**
     * @param Eve $eve
     */
    public function setEve(Eve $eve)
    {
        $this->eve = $eve;
    }

    /**
     * @param Event $event
     */
    abstract public function canHandle(Event $event);

    /**
     * @param Event $event
     */
    abstract public function handle(Event $event);

    /**
     * @return bool
     */
    public function shouldStopPropagation()
    {
        return $this->stopPropagation;
    }

    /**
     * @param Message $message
     */
    public function send(Message $message)
    {
        $this->eve->send($message);
    }
}
