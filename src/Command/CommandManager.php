<?php

namespace Eve\Command;

use Eve\Message;
use Eve\SlackClient;
use Eve\Command\Command;
use Illuminate\Support\Collection;

class CommandManager
{
    /**
     * @var Collection
     */
    private $commands;

    public function __construct(SlackClient $client)
    {
        $this->client = $client;

        $this->commands = new Collection();
    }

    public function addCommand(string $command)
    {
        $this->commands->push(new $command($this->client));
    }

    public function handle(Message $message)
    {
        $command = $this->commands->filter(function (Command $command) use ($message) {
            return $command->canHandle($message);
        })->first();
        
        if ($command) {
            $command->handle($message, $this->client);
        }
    }
}
