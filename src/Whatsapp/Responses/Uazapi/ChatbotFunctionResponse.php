<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class ChatbotFunctionResponse
{
    public readonly string $id;
    public readonly string $name;
    public readonly bool $active;
    public readonly string $description;
    public readonly string $method;
    public readonly string $endpoint;
    public readonly array $headers;
    public readonly array $body;
    public readonly array $parameters;
    public readonly string $owner;
    public readonly string $createdAt;
    public readonly string $updatedAt;
    
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->active = $data['active'];
        $this->description = $data['description'];
        $this->method = $data['method'];
        $this->endpoint = $data['endpoint'];
        $this->headers = $data['headers'];
        $this->body = $data['body'];
        $this->parameters = $data['parameters'];
        $this->owner = $data['owner'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['updated'];
    }
}