<?php

namespace App\Handlers\Human;

use App\Bots\Eve;
use App\Slack\Event;
use App\Slack\Message;
use App\Handlers\Handler;

final class HelloHandler extends Handler
{
    /**
     * {@inheritdoc}
     */
    public function canHandle(Event $event, Eve $eve)
    {
        return 
            $event->isMessage() && 
            ($event->isDirectMessage() || $event->mentions($eve->userId())) &&
            $event->matches('/\b(Hello|Hi|Hey|Yo)\b/i')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event, Eve $eve)
    {
        $eve->send(
            Message::saying('Howdy!')
            ->inChannel($event->channel())
            ->to($event->sender())
        );
    }
}
