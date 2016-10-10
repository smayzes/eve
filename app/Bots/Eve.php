<?php

namespace App\Bots;

use Slack\Payload;
use App\Slack\Event;
use App\Slack\Message;
use Slack\RealTimeClient;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

final class Eve
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var RealTimeClient
     */
    private $client;

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;

        $this->initialiseClient();
    }

    private function initialiseClient()
    {
        $this->loop   = Factory::create();
        $this->client = new RealTimeClient($this->loop);

        $this->client->setToken($this->token);

        $this->client->on(
            'message',
            function (Payload $data) {
                $handler = app()->make(\App\Handlers\Human\HelloHandler::class);
                $event = Event::withPayload($data);

                if ($handler->canHandle($event)) {
                    $handler->handle($event);
                }
            }
        );

    }

    /**
     * @return PromiseInterface
     */
    public function connect()
    {
        return $this->client->connect();
    }

    public function run()
    {
        $this->loop->run();
    }

    /**
     * @param Message $message
     */
    public function send(Message $message)
    {
        if ($message->isPrivate()) {
            return $this->sendPrivateMessage($message);
        }

        return $this
            ->client
            ->getChannelGroupOrDMById($message->channel())
            ->then(function ($channel) use ($message) {
                // Only mention the recipient if it isn't a Direct Message
                $mention = ($message->recipient() && $channel->getId()[0] !== 'D') ? "<@{$message->recipient()}> " : '';

                $this->client->send($mention . $message->content(), $channel);
            })
        ;
    }

    /**
     * @param Message $message
     */
    private function sendPrivateMessage(Message $message)
    {
        return $this
            ->client
            ->getUserById($message->recipient())
            ->then(function ($user) use ($message) {
                $this->client->getDMByUser($user)->then(function ($channel) use ($message) {
                    $this->client->send($message->content(), $channel);
                });
            })
        ;
    }
}
