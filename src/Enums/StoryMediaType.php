<?php

namespace Helvetitec\Messaging\Enums;

enum StoryMediaType: string
{
    case TEXT = 'text';
    case AUDIO = 'audio';
    case MYAUDIO = 'myaudio';
    case PTT = 'ptt';
    case VIDEO = 'video';
    case IMAGE = 'image';
}