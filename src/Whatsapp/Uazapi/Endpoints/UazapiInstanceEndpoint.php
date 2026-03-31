<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints;

/**
 * Baseclase for any Uazapi Instance endpoints
 */
class UazapiInstanceEndpoint extends UazapiEndpoint
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}