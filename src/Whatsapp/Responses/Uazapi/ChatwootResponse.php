<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

final class ChatwootResponse
{
    public readonly bool $enabled;
    public readonly string $url;
    public readonly int $accountId;
    public readonly int $inboxId;
    public readonly string $accessToken;
    public readonly bool $ignoreGroups;
    public readonly bool $signMessages;
    public readonly bool $createNewConversation;

    public function __construct(array $data)
    {
        $this->enabled = $data['chatwoot_enabled'];
        $this->url = $data['chatwoot_url'];
        $this->accountId = $data['chatwoot_account_id'];
        $this->inboxId = $data['chatwoot_inbox_id'];
        $this->accessToken = $data['chatwoot_access_token'];
        $this->ignoreGroups = $data['chatwoot_ignore_groups'];
        $this->signMessages = $data['chatwoot_sign_messages'];
        $this->createNewConversation = $data['chatwoot_create_new_conversation'];
    }
}