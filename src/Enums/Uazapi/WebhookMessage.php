<?php

namespace Helvetitec\Messaging\Enums\Uazapi;

enum WebhookMessage: string
{
    /**
     * Messages from the API. IMPORTANT: ALways use this filter to evade loops in automations.
     */
    case WAS_SENT_BY_API = 'wasSentByApi';
    /**
     * Messages not sent from the API
     */
    case WAS_NOT_SENT_BY_API = 'wasNotSendByApi';
    /**
     * Messages sent from the User
     */
    case FROM_ME_YES = 'fromMeYes';
    /**
     * Messages received from someone else
     */
    case FROM_ME_NO = 'fromMeNo';
    /**
     * Group messages
     */
    case IS_GROUP_YES = 'isGroupYes';
    /**
     * Messages not from a group
     */
    case IS_GROUP_NO = 'isGroupNo';
}