<?php

namespace Helvetitec\Messaging\Whatsapp\Instances;

final class UazapiInstance extends WhatsappInstance
{
    public readonly string $status;
    public readonly string $paircode;
    public readonly string $qrcode;
    public readonly string $profileName;
    public readonly string $profilePicUrl;
    public readonly bool $isBusiness;
    public readonly string $platform;
    public readonly string $systemName;
    public readonly string $owner;
    public readonly string $lastDisconnect;
    public readonly string $lastDisconnectReason;
    public readonly string $adminField01;
    public readonly string $adminField02;
    public readonly string $openAiApiKey;
    public readonly bool $chatbotEnabled;
    public readonly bool $chatbotIgnoreGroups;
    public readonly string $chatbotStopConverstion;
    public readonly int $chatbotStopMinutes;
    public readonly string $currentPresence;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->token = $data['token'];
        $this->status = $data['status'];
        $this->paircode = $data['paircode'];
        $this->qrcode = $data['qrcode'];
        $this->name = $data['name'];
        $this->profileName = $data['profileName'];
        $this->profilePicUrl = $data['profilePicUrl'];
        $this->isBusiness = $data['isBusiness'];
        $this->platform = $data['platform'];
        $this->systemName = $data['systemName'];
        $this->owner = $data['owner'];
        $this->lastDisconnect = $data['lastDisconnect'];
        $this->lastDisconnectReason = $data['lastDisconnectReason'];
        $this->adminField01 = $data['adminField01'];
        $this->adminField02 = $data['adminField02'];
        $this->openAiApiKey = $data['openai_apikey'];
        $this->chatbotEnabled = $data['chatbot_enabled'];
        $this->chatbotIgnoreGroups = $data['chatbot_ignoreGroups'];
        $this->chatbotStopConverstion = $data['chatbot_stopConversation'];
        $this->chatbotStopMinutes = $data['chatbot_stopMinutes'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['updated'];
        $this->currentPresence = $data['currentPresence'];
    }
}