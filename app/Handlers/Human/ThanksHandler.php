<?php

namespace App\Handlers\Human;

use App\Bots\Eve;
use App\Slack\Event;
use App\Slack\Message;
use App\Handlers\Handler;

final class ThanksHandler extends Handler
{
    /**
     * {@inheritdoc}
     */
    public function canHandle(Event $event, Eve $eve)
    {
        return 
            $event->isMessage() && 
            ($event->isDirectMessage() || $event->mentions($eve->userId())) &&
            $event->matches('/\b(Thanks|Cheers|Thankyou|Thank you)\b/i')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event, Eve $eve)
    {
        $eve->send(
            Message::saying('No problem!')
            ->inChannel($event->channel())
            ->to($event->sender())
        );
    }
}

