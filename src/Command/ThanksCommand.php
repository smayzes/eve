<?php

namespace Eve\Command;

use Slack\User;
use Eve\Message;
use Slack\Channel;
use Eve\SlackClient;
use Slack\ChannelInterface;

class ThanksCommand extends Command
{
    const PHRASES = [
        "You're welcome!",
        'No worries',
        'Sure thing',
        'No problemo!',
        'No sweat!',
    ];

    public function canHandle(Message $message): bool
    {
        return preg_match('/\b(thanks)\b/', $message->text());
    }

    public function handle(Message $message)
    {
        $messagePrefix = $message->isDm() ? '' : "<@{$message->user()}>: ";

        $content = collect(self::PHRASES)->random();

        $this->client->sendMessage(
            "{$messagePrefix}{$content}",
            $message->channel()
        );
    }
}

