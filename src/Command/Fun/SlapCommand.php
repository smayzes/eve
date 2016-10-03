<?php

namespace Eve\Command\Fun;

use Eve\Message;
use Eve\Command\ClientCommand;

final class SlapCommand extends ClientCommand
{
    /**
     * @param Message $message
     *
     * @return bool
     */
    public function canHandle(Message $message): bool
    {
        return !$message->isDm() && preg_match('/slap .+/', $message->text());
    }

    /**
     * @param Message $message
     */
    public function handle(Message $message)
    {
        $receiver = $this->receiver($message);

        $content = '';
        if (preg_match('/^<@' . $this->client->userId() . '>$/', $receiver) || strtolower($receiver) === 'eve') {
            $receiver = "<@{$message->user()}>";

            $content = "Ha ha! I don't think so!\n";
        }

        $content .= "_slaps {$receiver} around a bit with a wet fish._";

        $this->client->sendMessage(
            $content,
            $message->channel()
        );
    }

    /**
     * @param Message $message
     *
     * @return string
     */
    private function receiver(Message $message): string
    {
        preg_match('/slap ([<@]+)?([\w]+)(>)?/', $message->text(), $matches);

        return $matches[1] . $matches[2] . ($matches[3] ?? '');
    }
}
