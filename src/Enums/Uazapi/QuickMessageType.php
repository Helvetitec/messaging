<?php

namespace Helvetitec\Messaging\Enums\Uazapi;

enum QuickMessageType: string
{
    case TEXT = 'text';
    case AUDIO = 'audio';
    case MYAUDIO = 'myaudio';
    case PTT = 'ptt';
    case DOCUMENT = 'document';
    case VIDEO = 'video';
    case IMAGE = 'image';
}