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
            "name" => $this->name,
            "provider" => $this->provider,
            "model" => $this->model,
            "apikey" => $this->apiKey,
            "basePrompt" => $this->basePrompt,
            "maxTokens" => $this->maxTokens,
            "temperature" => $this->temperature,
            "diversityLevel" => $this->diversityLevel,
            "frequencyPenalty" => $this->frequencyPenalty,
            "presencePenalty" => $this->presencePenalty,
            "signMessages" => $this->signMessages,
            "readMessages" => $this->readMessages,
            "maxMessageLength" => $this->maxMessageLength,
            "typingDelay_seconds" => $this->typingDelay,
            "contextTimeWindow_hours" => $this->contextTimeWindow,
            "contextMaxMessages" => $this->contextMaxMessages,
            "contextMinMessages" => $this->contextMinMessages,
        ];
    }
}