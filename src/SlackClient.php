<?php

namespace Eve;

use Slack\RealTimeClient;
use Slack\ChannelInterface;

final class SlackClient extends RealTimeClient
{
    /**
     * @var string
     */
    private $userId = '';

    /**
     * @param string $id
     */
    public function setUserId(string $id)
    {
        $this->userId = $id;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $message
     * @param string $channel
     */
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
