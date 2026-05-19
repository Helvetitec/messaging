<?php 

namespace Helvetitec\Messaging\Enums;

enum InstanceStatus: string
{
    case DISCONNECTED = 'disconnected';
    case CONNECTING = 'connecting';
    case CONNECTED = 'connected';
}