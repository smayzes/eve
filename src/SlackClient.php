<?php

namespace Eve;

use Slack\RealtimeClient;
use Slack\ChannelInterface;

class SlackClient extends RealtimeClient
{
    /**
     * @var string
     */
    private $userId = '';

    public function setUserId(string $id)
    {
        $this->userId = $id;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function sendMessage(string $message, string $channel)
    {
        $this
            ->getChannelGroupOrDMByID($channel)
            ->then(function (ChannelInterface $channel) use ($message) {
                $this->send($message, $channel);
            })
        ; 
    }
}
