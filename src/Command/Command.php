<?php

namespace Eve\Command;

use Eve\Message;
use Eve\SlackClient;

abstract class Command
{
    public function __construct(SlackClient $client)
    {
        $this->client = $client;
    }

    abstract public function canHandle(Message $message): bool;
    abstract public function handle(Message $message);
}
