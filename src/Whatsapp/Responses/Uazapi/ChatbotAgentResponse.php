<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

use Helvetitec\Messaging\Enums\Uazapi\ChatbotAgentProvider;
use Helvetitec\Messaging\Enums\Uazapi\ChatbotAgentModel;

class ChatbotAgentResponse
{
    public readonly string $id;
    public readonly string $name;
    public readonly string $provider;
    public readonly string $apiKey;
    public readonly string $basePrompt;
    public readonly string $model;
    public readonly int $maxTokens;
    public readonly int $temperature;
    public readonly int $diversityLevel;
    public readonly int $frequencyPenalty;
    public readonly int $presencePenalty;
    public readonly bool $signMessages;
    public readonly bool $readMessages;
    public readonly int $maxMessageLength;
    public readonly int $typingDelay;
    public readonly int $contextTimeWindow;
    public readonly int $contextMinMessages;
    public readonly int $contextMaxMessages;
    public readonly string $owner;
    public readonly string $createdAt;
    public readonly string $updatedAt;
    
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->provider = $data['provider'] instanceof ChatbotAgentProvider ? $data['provider']->value : $data['provider'];
        $this->apiKey = $data['apikey'];
        $this->basePrompt = $data['basePrompt'];
        $this->model = $data['model'] instanceof ChatbotAgentModel ? $data['model']->value : $data['model'];
        $this->maxTokens = $data['maxTokens'];
        $this->temperature = $data['temperature'];
        $this->diversityLevel = $data['diversityLevel'];
        $this->frequencyPenalty = $data['frequencyPenalty'];
        $this->presencePenalty = $data['presencePenalty'];
        $this->signMessages = $data['signMessages'];
        $this->readMessages = $data['readMessages'];
        $this->maxMessageLength = $data['maxMessageLength'];
        $this->typingDelay = $data['typingDelay_seconds'];
        $this->contextTimeWindow = $data['contextTimeWindow_hours'];
        $this->contextMaxMessages = $data['contextMaxMessages'];
        $this->contextMinMessages = $data['contextMinMessages'];
        $this->owner = $data['owner'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['updated'];
    }
}