<?php

namespace Helvetitec\Messaging\Whatsapp\DTOs\Uazapi;

class ChatbotTriggerDto
{
    public readonly bool $active;
    public readonly string $type;
    public readonly string $agentId;
    public readonly bool $ignoreGroups;
    public readonly string $leadField;
    public readonly string $leadOperator;
    public readonly string $leadValue;
    public readonly int $priority;
    public readonly string $wordsToStart;
    public readonly int $responseDelay;

    public function __construct(array $data)
    {
        $this->active = $data['active'];
        $this->type = $data['type'];
        $this->agentId = $data['agent_id'];
        $this->ignoreGroups = $data['ignoreGroups'];
        $this->leadField = $data['lead_field'];
        $this->leadOperator = $data['lead_operator'];
        $this->leadValue = $data['lead_value'];
        $this->priority = $data['priority'];
        $this->wordsToStart = $data['wordsToStart'];
        $this->responseDelay = $data['responseDelay_seconds'];
    }

    public function to(): array
    {
        return [
            'active' => $this->active,
            'type' => $this->type,
            'agent_id' => $this->agentId,
            'ignoreGroups' => $this->ignoreGroups,
            'lead_field' => $this->leadField,
            'lead_operator' => $this->leadOperator,
            'lead_value' => $this->leadValue,
            'priority' => $this->priority,
            'wordsToStart' => $this->wordsToStart,
            'responseDelay_seconds' => $this->responseDelay
        ];
    }
}