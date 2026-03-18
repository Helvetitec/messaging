<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

use Helvetitec\Messaging\Whatsapp\Data\Uazapi\InstanceData;

class InstanceStatusResponse
{
    public readonly InstanceData $instance;
    public readonly array $status;
    
    public function __construct(InstanceData $instance, array $status)
    {
        $this->instance = $instance;
        $this->status = $status;
    }

    public function isConnected(): bool
    {
        return $this->status['connected'] ?? false;
    }

    public function isLoggedIn(): bool
    {
        return $this->status['loggedIn'] ?? false;
    }
}