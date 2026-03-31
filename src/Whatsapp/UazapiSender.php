<?php

namespace Helvetitec\Messaging\Whatsapp;

use Helvetitec\Messaging\Enums\StoryMediaType;
use Helvetitec\Messaging\Enums\Uazapi\PixType;
use Helvetitec\Messaging\Enums\WhatsappPresence;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\MessageConfigDto;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Messages\UazapiSendMessages;
use WhatsappSender;

class UazapiSender implements WhatsappSender
{
    private ?string $token = null;
    private ?string $receiver = null;
    private ?string $replyId = null;
    private ?string $subdomain = null;
    private int $delay = 0;

    /**
     * Set subdomain as server.
     *
     * @param string $server
     * @return static
     */
    public function server(string $server): static
    {
        $this->subdomain = $server;
        return $this;
    }

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

    #region Messages To Send
    public function sendText(string $text, bool $linkPreview = false): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendText($this->receiver, $text, $linkPreview, $messageConfig);
        return $response->messageId;
    }

    public function sendImage(string $file, string $caption): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendImage($this->receiver, $file, $caption, $messageConfig);
        return $response->messageId;
    }

    public function sendVideo(string $file, string $caption): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendVideo($this->receiver, $file, $caption, $messageConfig);
        return $response->messageId;
    }

    public function sendAudio(string $file): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendAudio($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendMyAudio(string $file): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendMyAudio($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendPtt(string $file): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendPtt($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendPtv(string $file): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendPtv($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendSticker(string $file): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendSticker($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendDocument(string $file, string $docName, string $caption): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendDocument($this->receiver, $file, $docName, $caption, $messageConfig);
        return $response->messageId;
    }

    public function sendVCard(string $fullName, string $phoneNumber, string $organization, string $email, string $url): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendVCard($this->receiver, $fullName, $phoneNumber, $organization, $email, $url, $messageConfig);
        return $response->messageId;
    }

    public function sendLocation(float $latitude, float $longitude, ?string $name, ?string $address, ): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessages->sendLocation($this->receiver, $latitude, $longitude, $name, $address, $messageConfig);
        return $response->messageId;
    }

    public function updatePresence(WhatsappPresence $presence, int $durationInMs): bool
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        return $sendMessages->updatePresence($this->receiver, $presence, $durationInMs);
    }

    public function sendStory(StoryMediaType $type, int $backgroundColor, int $font, ?string $text, ?string $file): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $response = $sendMessages->sendStory($type, $backgroundColor, $font, $text, $file);
        return $response->messageId;
    }

    public function sendButton(string $text, array $choices, ?string $footerText, ?string $imageButton, ): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendButton($this->receiver, $text, $choices, $footerText, $imageButton, $messageConfig);
        return $response->messageId;
    }

    public function sendCarousel(string $text, array $choices): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendCarousel($this->receiver, $text, $choices, $messageConfig);
        return $response->messageId;
    }

    public function sendAdvancedCarousel(string $text, array $carousel): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendAdvancedCarousel($this->receiver, $text, $carousel, $messageConfig);
        return $response->messageId;
    }

    public function sendList(string $text, array $choices, string $listButton, ?string $footerText): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendList($this->receiver, $text, $choices, $listButton, $footerText, $messageConfig);
        return $response->messageId;
    }

    public function sendPoll(string $text, array $choices, int $selectableCount): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendPoll($this->receiver, $text, $choices, $selectableCount, $messageConfig);
        return $response->messageId;
    }

    public function sendPixPayment(string $amount, string $text, string $pixKey, string $pixName, PixType $pixType): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendPixPayment($this->receiver, $amount, $text, $pixKey, $pixName, $pixType, $messageConfig);
        return $response->messageId;
    }

    public function sendInvoicePayment(string $amount, string $text, string $boletoCode, string $additionalNote, string $fileUrl, string $fileName, ?MessageConfigDto $messageConfig = null): string
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendInvoicePayment($this->receiver, $amount, $text, $boletoCode, $additionalNote, $fileUrl, $fileName, $messageConfig);
        return $response->messageId;
    }

    public function sendCombinedPayment(string $amount, string $text, string $pixKey, PixType $pixType, string $pixName, string $boletoCode, string $additionalNote, string $fileUrl, string $fileName,): string 
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendCombinedPayment($this->receiver, $amount, $text, $pixKey, $pixType, $pixName, $boletoCode, $additionalNote, $fileUrl, $fileName, $messageConfig);
        return $response->messageId;
    }

    public function sendPixButton(PixType $pixType, string $pixKey, ?string $pixName): string 
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->sendPixButton($this->receiver, $pixType, $pixKey, $pixName, $messageConfig);
        return $response->messageId;
    }

    public function requestLocation(string $text): string 
    {
        $sendMessages = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessages->requestLocation($this->receiver, $text, $messageConfig);
        return $response->messageId;
    }
    #endregion
    
}