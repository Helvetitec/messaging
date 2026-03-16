<?php

namespace Helvetitec\Messaging\Whatsapp\Instances;

abstract class WhatsappInstance
{
    public readonly string $id;
    public readonly string $token;
    public readonly string $name;
    public readonly string $createdAt;
    public readonly string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->token = $data['token'];
        $this->name = $data['name'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['updated'];
    }
}