<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class ProxyData
{
    public readonly bool $enabled;
    public readonly string $proxyUrl;
    public readonly string $lastTestAt;
    public readonly string $lastTestError;
    public readonly bool $validationError;

    public function __construct(
        bool $enabled,
        string $proxyUrl,
        string $lastTestAt,
        string $lastTestError,
        bool $validationError
    )
    {
        $this->enabled = $enabled;
        $this->proxyUrl = $proxyUrl;
        $this->lastTestAt = $lastTestAt;
        $this->lastTestError = $lastTestError;
        $this->validationError = $validationError;
    }
}