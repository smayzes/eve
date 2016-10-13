<?php

namespace App\Handlers\Human;

use App\Slack\Event;
use App\Slack\Message;
use App\Handlers\Handler;

final class HelloHandler extends Handler
{
    /**
     * {@inheritdoc}
     */
    public function canHandle(Event $event)
    {
        return 
            $event->isMessage() && 
            ($event->isDirectMessage() || $event->mentions($this->eve->userId())) &&
            $event->matches('/\b(Hello|Hi|Hey|Yo)\b/i')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $this->send(
            Message::saying('Howdy!')
            ->inChannel($event->channel())
            ->to($event->sender())
        );
    }
}
