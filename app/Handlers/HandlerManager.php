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
     * @var Eve
     */
    private $eve;

    /**
     * @param Collection $handlers
     */
    private function __construct(Collection $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @param Eve $eve
     */
    public function setEve(Eve $eve)
    {
        $this->eve = $eve;

        $this->handlers->each(function (Handler $handler) use ($eve) {
            $handler->setEve($eve);
        });
    }

    /**
     * @param Event $event
     */
    public function handle(Event $event)
    {
        if (!$event->isBotMessage()) {
            $this->handlers->each(function (Handler $handler) use ($event) {
                if ($handler->canHandle($event)) {
                    $handler->handle($event);

                    return ! $handler->shouldStopPropagation();
                }
            });
        }
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
