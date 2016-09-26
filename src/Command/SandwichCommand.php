<?php

namespace Eve\Command;

use Slack\User;
use Eve\Message;
use Slack\Channel;
use Eve\SlackClient;
use Slack\ChannelInterface;

class SandwichCommand extends Command
{
    public function canHandle(Message $message): bool
    {
        return preg_match('/(sudo )?make me a sandwich/', $message->text());
    }

    public function handle(Message $message)
    {
        $messagePrefix = $message->isDm() ? '' : "<@{$message->user()}>: ";

        $content = false === stripos($message->text(), 'sudo') ?
            'No, make one yourself' :
            'User is not in the sudoers file. This incident will be reported.'
        ;

        $this->client->sendMessage(
            "{$messagePrefix}{$content}",
            $message->channel()
        );
    }
}

