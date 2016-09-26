<?php

namespace Eve\Command;

use Slack\User;
use Eve\Message;
use Slack\Channel;
use Eve\SlackClient;
use Slack\ChannelInterface;

class PingCommand extends Command
{
    public function canHandle(Message $message): bool
    {
        return false !== stripos($message->text(), 'ping');
    }

    public function handle(Message $message)
    {
        $messagePrefix = $message->isDm() ? '' : "<@{$message->user()}>: ";

        $this->client->sendMessage(
            "{$messagePrefix}Pong!",
            $message->channel()
        );
    }
}
