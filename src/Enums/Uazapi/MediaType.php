<?php

namespace Helvetitec\Messaging\Enums\Uazapi;

enum MediaType: string
{
    case AUDIO = 'audio';
    case MYAUDIO = 'myaudio';
    case PTT = 'ptt';
    case PTV = 'ptv';
    case STICKER = 'sticker';
    case DOCUMENT = 'document';
    case VIDEO = 'video';
    case IMAGE = 'image';
}