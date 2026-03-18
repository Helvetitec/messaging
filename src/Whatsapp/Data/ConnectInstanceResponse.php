<?php

namespace Helvetitec\Messaging\Whatsapp\Data;

use Helvetitec\Messaging\Whatsapp\Instances\WhatsappInstance;

final class ConnectInstanceResponse
{
    public bool $connected;
    public bool $loggedIn;
    public string $jid;
    public WhatsappInstance $instance;

    public function __construct(bool $connected, bool $loggedIn, string $jid, WhatsappInstance $instance)
    {
        $this->connected = $connected;
        $this->loggedIn = $loggedIn;
        $this->jid = $jid;
        $this->instance = $instance;
    }
}