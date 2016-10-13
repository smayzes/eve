<?php

namespace App\Handlers\Fun;

use App\Slack\Event;
use App\Slack\Message;
use App\Handlers\Handler;
use Illuminate\Support\Collection;

final class SlapHandler extends Handler
{
    /**
     * {@inheritdoc}
     */
    public function canHandle(Event $event)
    {
        return 
            $event->isMessage() && 
            $event->mentions($this->eve->userId()) &&
            $event->matches('/slap .+/i')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $receivers = $this->receivers($event);

        $content = '';

        // Protect against slapping Eve
        if ($receivers->contains("<@{$this->eve->userId()}>")) {
            $receivers = collect(["<@{$event->sender()}>"]);
            $content   = "Ha ha! I don't think so!\n";
        }

        // Protect against slapping users who aren't there
        if (0 === $receivers->count()) {
            $receivers = collect(["<@{$event->sender()}>"]);
            $content   = "I can only slap people who are here!\n";
        }

        $content .= "_slaps {$this->joinReceivers($receivers)} with a large fish_";

        $this->send(
            Message::saying($content)
            ->inChannel($event->channel())
        );
    }

    /**
     * @param Event $event
     *
     * @return Collection
     */
    private function receivers(Event $event)
    {
        preg_match_all(
            '/(<@[\w]+>)/', 
            substr($event->text(), strpos($event->text(), 'slap ') + 5), 
            $matches
        );

        return collect($matches[0]);
    }

    /**
     * @param Collection $receivers
     *
     * @return string
     */
    private function joinReceivers(Collection $receivers)
    {
        $last = $receivers->pop();

        if ($receivers->count()) {
            return $receivers->implode(', ') . ' and ' . $last;
        }

        return $last;
    }
}
