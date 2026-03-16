<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints;

/**
 * Baseclass for any Uazapi Admin endpoint
 */
abstract class UazapiAdminEndpoint extends UazapiEndpoint
{
    /**
     * The admin token used for the endpoint
     *
     * @var string
     */
    public string $adminToken;
}