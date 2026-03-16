<?php

namespace Helvetitec\Messaging\Enums;

enum BulkMessageStatus: string
{
    case SCHEDULED = 'scheduled';
    case SENDING = 'sending';
    case PAUSED = 'paused';
    case DONE = 'done';
    case DELETING = 'deleting';
}