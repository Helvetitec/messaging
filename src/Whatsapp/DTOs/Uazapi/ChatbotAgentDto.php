<?php

namespace Helvetitec\Messaging\Whatsapp\DTOs\Uazapi;

use Helvetitec\Messaging\Enums\Uazapi\ChatbotAgentProvider;
use Helvetitec\Messaging\Enums\Uazapi\ChatbotAgentModel;

class ChatbotAgentDto
{
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

    public function __construct(array $data)
    {
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
    }

    public function to(): array
    {
        return [
            "id" =>"123e4567-e89b-12d3-a456-426614174000",
            "name" =>"string",
            "provider" =>"openai",
            "model" =>"string",
            "apikey" =>"string",
            "basePrompt" =>"string",
            "maxTokens" =>0,
            "temperature" =>0,
            "diversityLevel" =>0,
            "frequencyPenalty" =>0,
            "presencePenalty" =>0,
            "signMessages" =>false,
            "readMessages" =>false,
            "maxMessageLength" =>0,
            "typingDelay_seconds" =>0,
            "contextTimeWindow_hours" =>0,
            "contextMaxMessages" =>0,
            "contextMinMessages" =>0,
            "owner" =>"string",
            "created" =>"2024-01-15T10:30:00Z",
            "updated" =>"2024-01-15T10:30:00Z"
        ];
    }
}