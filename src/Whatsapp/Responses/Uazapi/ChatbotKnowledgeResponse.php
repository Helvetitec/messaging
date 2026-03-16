<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class ChatbotKnowledgeResponse
{
    public readonly string $id;
    public readonly string $title;
    public readonly bool $active;
    public readonly string $content;
    public readonly string $vectorStatus;
    public readonly bool $isVectorized;
    public readonly string $lastVectorizedAt;
    public readonly int $priority;
    public readonly string $owner;
    public readonly string $createdAt;
    public readonly string $updatedAt;
    
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->active = $data['active'];
        $this->content = $data['content'];
        $this->vectorStatus = $data['vectorStatus'];
        $this->isVectorized = $data['isVectorized'];
        $this->lastVectorizedAt = $data['lastVectorizedAt'];
        $this->owner = $data['owner'];
        $this->priority = $data['priority'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['updated'];
    }
}