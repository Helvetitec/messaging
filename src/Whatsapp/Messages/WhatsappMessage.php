<?php

namespace Helvetitec\Messaging\Whatsapp\Messages;

use Helvetitec\Messaging\Message;

abstract class WhatsappMessage extends Message
{
    /**
     * Whatsapp Instance id
     * 
     * @var string
     */
    public string $instance;

    /**
     * LID connected to the Whatsapp messages remote
     *
     * @var string|null
     */
    public ?string $remoteLid;

    /**
     * JID connected to the Whatsapp messages remote
     *
     * @var string|null
     */
    public ?string $remoteJid;

    /**
     * Phonenumber connected to the Whatsapp messages remote
     *
     * @var string|null
     */
    public ?string $remotePn;

    /**
     * The name related to the Whatsapp messages remote
     *
     * @var string|null
     */
    public ?string $remoteName;

    /**
     * Returns an identifier for the messages remote
     *
     * @return string|null
     */
    public function remote(): ?string{
        return !empty($this->remotePn) ? $this->remotePn : (!empty($this->remoteJid) ? $this->remoteJid : $this->remoteLid);
    }
}