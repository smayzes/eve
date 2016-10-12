<?php

namespace App\Handlers;

use App\Bots\Eve;
use App\Slack\Event;
use Illuminate\Support\Collection;

final class HandlerManager
{
    /**
     * @var Collection
     */
    private $handlers;

    /**
     * @param Collection $handlers
     */
    private function __construct(Collection $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @param Event $event
     * @param Eve   $eve
     */
    public function handle(Event $event, Eve $eve)
    {
        $this->handlers->each(function (Handler $handler) use ($event, $eve) {
            if ($handler->canHandle($event, $eve)) {
                $handler->handle($event, $eve);
            }
        });
    }

    /**
     * @param Collection $handlers
     *
     * @return self
     */
    public static function withHandlers(Collection $handlers)
    {
        return new self($handlers);
    }
}
