<?php

namespace Helvetitec\Messaging\Whatsapp\Instances;

abstract class WhatsappInstance
{
    public readonly string $id;
    public readonly string $token;
    public readonly string $name;
    public readonly string $createdAt;
    public readonly string $updatedAt;
}