<?php

namespace Eve\Command;

use Eve\Message;
use Eve\Loader\HasData;
use Eve\Loader\HasDataTrait;
use Illuminate\Support\Collection;

final class ThanksCommand extends ClientCommand implements HasData
{
    use HasDataTrait;

    /**
     * @param Message $message
     *
     * @return bool
     */
    public function canHandle(Message $message): bool
    {
        return preg_match('/\b(thanks)\b/', $message->text());
    }

    /**
     * @param Message $message
     */
    public function handle(Message $message)
    {
        $this->loadData();

        $messagePrefix = $message->isDm() ? '' : "<@{$message->user()}>: ";
        $content       = $this->data->random();

        $this->client->sendMessage(
            "{$messagePrefix}{$content}",
            $message->channel()
        );
    }
}
