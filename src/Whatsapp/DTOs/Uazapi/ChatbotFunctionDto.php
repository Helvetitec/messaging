<?php

namespace Helvetitec\Messaging\Whatsapp\DTOs\Uazapi;

class ChatbotFunctionDto
{
    public readonly string $name;
    public readonly bool $active;
    public readonly string $description;
    public readonly string $method;
    public readonly string $endpoint;
    public readonly array $headers;
    public readonly array $body;
    public readonly array $parameters;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->active = $data['active'];
        $this->description = $data['description'];
        $this->method = $data['method'];
        $this->endpoint = $data['endpoint'];
        $this->headers = $data['headers'];
        $this->body = $data['body'];
        $this->parameters = $data['parameters'];
    }

    public function to(): array
    {
        return [
            "name" => $this->name,
            "active" => $this->active,
            "description" => $this->description,
            "method" => $this->method,
            "endpoint" => $this->endpoint,
            "headers" => $this->headers,
            "body" => $this->body,
            "parameters" => $this->parameters
        ];
    }
}