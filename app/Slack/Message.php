<?php

namespace App\Slack;

final class Message
{
    /**
     * @param string
     */
    private $content;

    /**
     * @param string
     */
    private $recipient;

    /**
     * @param string
     */
    private $channel;

    /**
     * @param bool
     */
    private $private = false;

    /**
     * @param string $content
     */
    private function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $recipient
     *
     * @return $this
     */
    public function to($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @param string $channel
     *
     * @return $this
     */
    public function inChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return $this
     */
    public function privately()
    {
        $this->private = true;

        return $this;
    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function recipient()
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function channel()
    {
        return $this->channel;
    }

    /**
     * @return bool
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public static function saying($message)
    {
        return new self($message);
    }
}
