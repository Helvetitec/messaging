<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints;

/**
 * Baseclass for any Uazapi endpoint
 */
abstract class UazapiEndpoint
{
    /**
     * The subdomain fr the Uazapi Endpoint.
     *
     * @var string
     */
    public string $subdomain;

    /**
     * Returns the root url for the API access
     *
     * @return string
     */
    protected static function root(): string
    {
        return "https://".self::$subdomain.".uazapi.com/";
    }
}