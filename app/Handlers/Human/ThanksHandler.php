<?php

namespace App\Handlers\Human;

use App\Slack\Event;
use App\Slack\Message;
use App\Handlers\Handler;

final class ThanksHandler extends Handler
{
    /**
     * {@inheritdoc}
     */
    public function canHandle(Event $event)
    {
        return 
            $event->isMessage() && 
            ($event->isDirectMessage() || $event->mentions($this->eve->userId())) &&
            $event->matches('/\b(Thanks|Cheers|Thankyou|Thank you)\b/i')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $this->send(
            Message::saying('No problem!')
            ->inChannel($event->channel())
            ->to($event->sender())
        );
    }
}

