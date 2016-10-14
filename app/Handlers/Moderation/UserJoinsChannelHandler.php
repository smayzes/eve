<?php

namespace App\Handlers\Moderation;

use App\Slack\Event;
use App\Slack\Message;
use App\Handlers\Handler;
use App\Loader\LoadsData;
use App\Loader\JsonLoader;

final class UserJoinsChannelHandler extends Handler
{
    use LoadsData;

    protected $dataFile = 'channel-joins.json';

    /**
     * @param JsonLoader $loader
     */
    public function __construct(JsonLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * {@inheritdoc}
     */
    public function canHandle(Event $event)
    {
        return 
            $event->isMessage() &&
            $event->isChannelJoin()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $this->loadData();

        $this->send(
            Message::saying(str_replace(['<CHANNEL>', '<USER>'], ["<#{$event->channel()}>", "<@{$event->sender()}>"], $this->data->random()))
            ->inChannel($event->channel())
        );
    }
}
