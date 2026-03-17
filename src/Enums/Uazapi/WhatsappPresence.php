<?php

namespace Helvetitec\Messaging\Enums\Uazapi;

enum WhatsappPresence: string
{
    case COMPOSING = 'composing';
    case RECORDING = 'recording';
    case PAUSED = 'paused';
}