<?php

namespace App\Handlers;

use App\Bots\Eve;
use App\Slack\Event;
use App\Slack\Message;

abstract class Handler
{
    /**
     * @param Event $event
     */
    abstract public function canHandle(Event $event, Eve $eve);

    /**
     * @param Event $event
     */
    abstract public function handle(Event $event, Eve $eve);
}
