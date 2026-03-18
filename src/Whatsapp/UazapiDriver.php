<?php

namespace Helvetitec\Messaging\Whatsapp;

use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\MessageConfigDto;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Messages\UazapiSendMessages;
use WhatsappDriver;

class UazapiDriver implements WhatsappDriver
{
    private ?string $token = null;
    private ?string $receiver = null;
    private ?string $replyId = null;
    private int $delay = 0;

    public function token(string $token): static
    {
        $this->token = $token;
        return $this;
    }

    public function receiver(string $receiver): static
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function reply(string $replyId): static
    {
        $this->replyId = $replyId;
        return $this;
    }

    public function delay(int $delay): static
    {
        $this->delay = $delay;
        return $this;
    }

    //Final calls
    public function sendText(string $text, bool $linkPreview = false): string
    {
        $sendMessages = new UazapiSendMessages();
        $sendMessages->token = $this->token;
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendText($this->receiver, $text, $linkPreview, $messageConfig);
        return $response->messageId;
    }
}