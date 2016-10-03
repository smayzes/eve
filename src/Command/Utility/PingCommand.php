<?php

namespace Eve\Command\Utility;

use Eve\Message;
use Eve\Command\ClientCommand;

final class PingCommand extends ClientCommand
{
    /**
     * @param Message $message
     *
     * @return bool
     */
    public function canHandle(Message $message): bool
    {
        return false !== stripos($message->text(), 'ping');
    }

    /**
     * @param Message $message
     */
    public function handle(Message $message)
    {
        $messagePrefix = $message->isDm() ? '' : "<@{$message->user()}>: ";

        $this->client->sendMessage(
            "{$messagePrefix}`ACK`",
            $message->channel()
        );
    }
}
