<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

use Helvetitec\Messaging\Enums\InstanceStatus;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\InstanceData;

class InstanceStatusResponse
{
    public readonly InstanceData $instance;
    public readonly array $status;
    public readonly InstanceStatus $instanceStatus;
    
    public function __construct(InstanceData $instance, array $status)
    {
        $this->instance = $instance;
        $this->status = $status;
        $this->instanceStatus = $instance->status == 'connected' ? InstanceStatus::CONNECTED : ($instance->status == 'connecting' ? InstanceStatus::CONNECTING : InstanceStatus::DISCONNECTED);
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