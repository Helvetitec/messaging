<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class InstanceData
{
    public readonly string $id;
    public readonly string $token;
    public readonly string $status;
    public readonly string $paircode;
    public readonly string $qrcode;
    public readonly string $name;
    public readonly string $profileName;
    public readonly string $profilePicUrl;
    public readonly bool $isBusiness;
    public readonly string $platform;
    public readonly string $systemName;
    public readonly string $owner;
    public readonly string $currentPresence;
    public readonly string $lastDisconnect;
    public readonly string $lastDisconnectReason;
    public readonly string $adminField1;
    public readonly string $adminField2;
    public readonly string $openAiApiKey;
    public readonly bool $chatbotEnabled;
    public readonly bool $chatbotIgnoreGroups;
    public readonly string $chatbotStopConversation;
    public readonly int $chatbotStopMinutes;
    public readonly int $chatbotStopWhenYouSendMessage;
    public readonly array $fieldsMap;
    public readonly string $currentTime;
    public readonly string $createdAt;
    public readonly string $updatedAt;

    public function __construct(array $payload)
    {
        $this->id = $payload['id'];
        $this->token = $payload['token'];
        $this->status = $payload['status'];
        $this->paircode = $payload['paircode'];
        $this->qrcode = $payload['qrcode'];
        $this->name = $payload['name'];
        $this->profileName = $payload['profileName'];
        $this->profilePicUrl = $payload['profilePicUrl'];
        $this->isBusiness = $payload['isBusiness'];
        $this->platform = $payload['platform'];
        $this->systemName = $payload['systemName'];
        $this->owner = $payload['owner'];
        $this->currentPresence = $payload['current_presence'];
        $this->lastDisconnect = $payload['lastDisconnect'];
        $this->lastDisconnectReason = $payload['lastDisconnectReason'];
        $this->adminField1 = $payload['adminField01'];
        $this->adminField2 = $payload['adminField02'];
        $this->openAiApiKey = $payload['openai_apikey'];
        $this->chatbotEnabled = $payload['chatbot_enabled'];
        $this->chatbotIgnoreGroups = $payload['chatbot_ignoreGroups'];
        $this->chatbotStopConversation = $payload['chatbot_stopConversation'];
        $this->chatbotStopMinutes = $payload['chatbot_stopMinutes'];
        $this->chatbotStopWhenYouSendMessage = $payload['chatbot_stopWhenYouSendMsg'];
        $this->fieldsMap = $payload['fieldsMap'];
        $this->currentTime = $payload['currentTime'];
        $this->createdAt = $payload['created'];
        $this->updatedAt = $payload['updated'];
    }

}