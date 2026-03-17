<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class LabelResponse
{
    public readonly string $id;
    public readonly string $name;
    public readonly string $color;
    public readonly string $colorHex;
    public readonly string $createdAt;
    public readonly string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->color = $data['color'];
        $this->colorHex = $data['colorHex'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['updated'];
    }
}