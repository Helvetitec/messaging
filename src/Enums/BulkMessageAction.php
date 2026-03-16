<?php

namespace Helvetitec\Messaging\Enums;

enum BulkMessageAction: string
{
    case CONTINUE = 'continue';
    case STOP = 'stop';
    case DELETE = 'delete';
}