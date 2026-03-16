<?php 

namespace Helvetitec\Messaging\Enums;

enum BulkMessageType: string
{
    case TEXT = 'text'; 
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';
    case CONTACT = 'contact';
    case LOCATION = 'location';
    case LIST = 'list';
    case BUTTON = 'button';
    case POLL = 'poll';
    case CAROUSEL = 'carousel';
}