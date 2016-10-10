<?php

namespace App\Slack;

use Slack\Payload;

final class Event
{
    /**
     * @param Payload
     */
    private $payload;

    /**
     * @param Payload $payload
     */
    private function __construct(Payload $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return int
     */
    public function matches($pattern)
    {
        return preg_match($pattern, $this->payload['text']);
    }

    /**
     * @return string
     */
    public function sender()
    {
        return $this->payload['user'];
    }

    /**
     * @return string
     */
    public function channel()
    {
        return $this->payload['channel'];
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return bool
     */
    public function __call($name, array $arguments)
    {
        if (!starts_with($name, 'is')) {
            return false;
        }
        
        return $this->payload['type'] === snake_case(substr($name, 2));
    }

    /**
     * @param Payload $payload
     *
     * @return self
     */
    public static function withPayload(Payload $payload)
    {
        return new self($payload);
    }
}
