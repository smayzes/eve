<?php

namespace Eve\Command;

use Slack\User;
use Eve\Message;
use Slack\Channel;
use Eve\SlackClient;
use Slack\ChannelInterface;

class SlapCommand extends Command
{
    public function canHandle(Message $message): bool
    {
        return !$message->isDm() && preg_match('/slap .+/', $message->text());
    }

    public function handle(Message $message)
    {
        $receiver = $this->receiver($message);

        $content = '';
        if (preg_match('/^<@' . $this->client->userId() . '>$/', $receiver) || strtolower($receiver) === 'eve') {
            $receiver = "<@{$message->user()}>";

            $content = 'Nice try.' . "\n";
        }

        $content .= "_slaps {$receiver} around a bit with a large trout._";
        
        $this->client->sendMessage(
            $content,
            $message->channel()
        );
    }

    private function receiver(Message $message): string
    {
        preg_match('/^[^ ]+ [^ ]+ ([^ ]+)/', $message->text(), $matches);

        return $matches[1];
    }
}


