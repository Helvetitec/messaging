<?php

namespace Helvetitec\Messaging;

abstract class Message
{
    /**
     * Unique identifier for the Message
     *
     * @var string
     */
    public string $id;

    /**
     * Is the message from the instance or from the remote?
     *
     * @var boolean
     */
    public bool $fromMe;
}