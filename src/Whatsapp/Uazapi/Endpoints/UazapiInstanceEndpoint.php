<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints;

/**
 * Baseclase for any Uazapi Instance endpoints
 */
class UazapiInstanceEndpoint extends UazapiEndpoint
{
    public string $token;

    public function __construct(string $subdomain, string $token)
    {
        $this->subdomain = $subdomain;
        $this->token = $token;
    }
}