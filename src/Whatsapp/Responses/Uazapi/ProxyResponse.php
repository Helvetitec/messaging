<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class ProxyResponse
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
        string $validationError
    )
    {
        $this->enabled = $enabled;
        $this->proxyUrl = $proxyUrl;
        $this->lastTestAt = $lastTestAt;
        $this->lastTestError = $lastTestError;
        $this->validationError = $validationError;
    }
}