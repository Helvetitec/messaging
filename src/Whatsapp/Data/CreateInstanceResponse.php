<?php

namespace Helvetitec\Messaging\Whatsapp\Data;

use Helvetitec\Messaging\Whatsapp\Instances\WhatsappInstance;

final class CreateInstanceResponse
{
    /**
     * Token of the Instance
     *
     * @var string
     */
    public readonly string $token;
    /**
     * QRCode of the instance, if could be fetched
     *
     * @var string|null
     */
    public readonly ?string $qrcode;
    /**
     * Paircode of the instance if could be fetched
     *
     * @var string|null
     */
    public readonly ?string $paircode;
    /**
     * Instance of the request
     *
     * @var WhatsappInstance|null
     */
    public readonly ?WhatsappInstance $instance;

    public function __construct(string $token, ?string $qrcode = null, ?string $paircode = null, ?WhatsappInstance $instance = null)
    {
        $this->token = $token;
        $this->qrcode = $qrcode;
        $this->paircode = $paircode;
        $this->instance = $instance;
    }
}