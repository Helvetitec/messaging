<?php

namespace Helvetitec\Messaging\Whatsapp\Data;

use Helvetitec\Messaging\Whatsapp\Instances\WhatsappInstance;

final class InstanceStatusResponse
{
    public readonly WhatsappInstance $instance;
    public readonly bool $connected;
    public readonly bool $loggedIn;
    public readonly string $jid;

    public function __construct(WhatsappInstance $instance, bool $connected, bool $loggedIn, string $jid)
    {
        $this->instance = $instance;
        $this->connected = $connected;
        $this->loggedIn = $loggedIn;
        $this->jid = $jid;
    }
}