<?php

namespace Eve;

final class Message
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->channel = $data['channel'] ?? null;
        $this->user    = $data['user'] ?? null;
        $this->text    = $data['text'] ?? null;
        $this->subtype = $data['subtype'] ?? null;
    }

    /**
     * @return string
     */
    public function channel()
    {
        return $this->channel;
    }

    /**
     * @return string
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function text()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function subtype()
    {
        return $this->subtype;
    }

    /**
     * @return bool
     */
    public function isDm(): bool
    {
        return $this->channel[0] === 'D';
    }
}
