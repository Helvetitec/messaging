<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class ChatbotTriggerResponse
{
    public readonly string $id;
    public readonly bool $active;
    public readonly string $type;
    public readonly string $agentId;
    public readonly string $flowId;
    public readonly string $quickReplyId;
    public readonly bool $ignoreGroups;
    public readonly string $leadField;
    public readonly string $leadOperator;
    public readonly string $leadValue;
    public readonly int $priority;
    public readonly string $wordsToStart;
    public readonly int $responseDelay;
    public readonly string $owner;
    public readonly string $createdAt;
    public readonly string $updatedAt;
    
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->active = $data['active'];
        $this->type = $data['type'];
        $this->agentId = $data['agent_id'];
        $this->flowId = $data['flow_id'];
        $this->quickReplyId = $data['quickReply_id'];
        $this->ignoreGroups = $data['ignoreGroups'];
        $this->leadField = $data['lead_field'];
        $this->leadOperator = $data['lead_operator'];
        $this->leadValue = $data['lead_value'];
        $this->priority = $data['priority'];
        $this->wordsToStart = $data['wordsToStart'];
        $this->responseDelay = $data['responseDelay_seconds'];
        $this->owner = $data['owner'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['updated'];
    }
}