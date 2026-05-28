<?php

namespace Helvetitec\Messaging\Whatsapp;

use Helvetitec\Messaging\Contracts\WhatsappHandler;
use Helvetitec\Messaging\Enums\StoryMediaType;
use Helvetitec\Messaging\Enums\Uazapi\PixType;
use Helvetitec\Messaging\Enums\WhatsappPresence;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\InstanceData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\MessageData;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\MessageConfigDto;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\SystemStatusDto;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\InstanceStatusResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Admin\UazapiAdmin;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Contacts\UazapiContacts;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Instance\UazapiInstance;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Messages\UazapiMessages;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Messages\UazapiSendMessages;
use Illuminate\Support\Collection;

class UazapiHandler implements WhatsappHandler
{
    private ?string $receiver = null;
    private ?string $replyId = null;
    private int $delay = 0;
    
    public function __construct(
        private ?string $subdomain = null,
        private ?string $adminToken = null,
        private ?string $token = null,
    )
    {
    }
    
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

    public function adminToken(string $adminToken): static
    {
        $this->adminToken = $adminToken;
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

    #region Messages 
    public function findMessage(string $messageId): MessageData
    {
        $messagesEndpoint = new UazapiMessages($this->subdomain, $this->token);
        return $messagesEndpoint->loadMessage($messageId);
    }
    #endregion

    #region Send Messages
    public function sendText(string $text, bool $linkPreview = false): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendText($this->receiver, $text, $linkPreview, $messageConfig);
        return $response->messageId;
    }

    public function sendImage(string $file, string $caption): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendImage($this->receiver, $file, $caption, $messageConfig);
        return $response->messageId;
    }

    public function sendVideo(string $file, string $caption): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendVideo($this->receiver, $file, $caption, $messageConfig);
        return $response->messageId;
    }

    public function sendAudio(string $file): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendAudio($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendMyAudio(string $file): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendMyAudio($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendPtt(string $file): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendPtt($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendPtv(string $file): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendPtv($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendSticker(string $file): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendSticker($this->receiver, $file, $messageConfig);
        return $response->messageId;
    }

    public function sendDocument(string $file, string $docName, string $caption): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendDocument($this->receiver, $file, $docName, $caption, $messageConfig);
        return $response->messageId;
    }

    public function sendVCard(string $fullName, string $phoneNumber, string $organization, string $email, string $url): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendVCard($this->receiver, $fullName, $phoneNumber, $organization, $email, $url, $messageConfig);
        return $response->messageId;
    }

    public function sendLocation(float $latitude, float $longitude, ?string $name, ?string $address, ): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay,
            replyId: $this->replyId
        );
        $response = $sendMessagesEndpoint->sendLocation($this->receiver, $latitude, $longitude, $name, $address, $messageConfig);
        return $response->messageId;
    }

    public function updatePresence(WhatsappPresence $presence, int $durationInMs): bool
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        return $sendMessagesEndpoint->updatePresence($this->receiver, $presence, $durationInMs);
    }

    public function sendStory(StoryMediaType $type, int $backgroundColor, int $font, ?string $text, ?string $file): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $response = $sendMessagesEndpoint->sendStory($type, $backgroundColor, $font, $text, $file);
        return $response->messageId;
    }

    public function sendButton(string $text, array $choices, ?string $footerText, ?string $imageButton, ): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendButton($this->receiver, $text, $choices, $footerText, $imageButton, $messageConfig);
        return $response->messageId;
    }

    public function sendCarousel(string $text, array $choices): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendCarousel($this->receiver, $text, $choices, $messageConfig);
        return $response->messageId;
    }

    public function sendAdvancedCarousel(string $text, array $carousel): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendAdvancedCarousel($this->receiver, $text, $carousel, $messageConfig);
        return $response->messageId;
    }

    public function sendList(string $text, array $choices, string $listButton, ?string $footerText): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendList($this->receiver, $text, $choices, $listButton, $footerText, $messageConfig);
        return $response->messageId;
    }

    public function sendPoll(string $text, array $choices, int $selectableCount): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendPoll($this->receiver, $text, $choices, $selectableCount, $messageConfig);
        return $response->messageId;
    }

    public function sendPixPayment(string $amount, string $text, string $pixKey, string $pixName, PixType $pixType): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendPixPayment($this->receiver, $amount, $text, $pixKey, $pixName, $pixType, $messageConfig);
        return $response->messageId;
    }

    public function sendInvoicePayment(string $amount, string $text, string $boletoCode, string $additionalNote, string $fileUrl, string $fileName, ?MessageConfigDto $messageConfig = null): string
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendInvoicePayment($this->receiver, $amount, $text, $boletoCode, $additionalNote, $fileUrl, $fileName, $messageConfig);
        return $response->messageId;
    }

    public function sendCombinedPayment(string $amount, string $text, string $pixKey, PixType $pixType, string $pixName, string $boletoCode, string $additionalNote, string $fileUrl, string $fileName,): string 
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendCombinedPayment($this->receiver, $amount, $text, $pixKey, $pixType, $pixName, $boletoCode, $additionalNote, $fileUrl, $fileName, $messageConfig);
        return $response->messageId;
    }

    public function sendPixButton(PixType $pixType, string $pixKey, ?string $pixName): string 
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->sendPixButton($this->receiver, $pixType, $pixKey, $pixName, $messageConfig);
        return $response->messageId;
    }

    public function requestLocation(string $text): string 
    {
        $sendMessagesEndpoint = new UazapiSendMessages($this->subdomain, $this->token);
        $messageConfig = new MessageConfigDto(
            delay: $this->delay
        );
        $response = $sendMessagesEndpoint->requestLocation($this->receiver, $text, $messageConfig);
        return $response->messageId;
    }
    #endregion
    
    #region Contacts
    
    /**
     * Verify numbers and return a collection of NumberVerifyData.
     *
     * @param array<int,string> $numbers
     * @return Collection<int,\Helvetitec\Messaging\Whatsapp\Data\Uazapi\NumberVerifyData>
     */
    public function verifyNumbers(array $numbers): Collection
    {
        $contactsEndpoint = new UazapiContacts($this->subdomain, $this->token);
        return $contactsEndpoint->verifyNumbers($numbers);
    }

    #endregion

    #region Admin
    public function createInstance(
        string $name,
        ?string $adminField01 = null,
        ?string $adminField02 = null
    ): InstanceData
    {
        $adminEndpoint = new UazapiAdmin($this->subdomain, $this->adminToken);
        return $adminEndpoint->createInstance($name, $adminField01, $adminField02);
    }

    public function systemStatus(): SystemStatusDto
    {
        $adminEndpoint = new UazapiAdmin($this->subdomain, $this->adminToken);
        return $adminEndpoint->systemStatus();
    }
    #endregion

    #region Instance
    public function connectInstance(
        string $systemName, 
        ?string $phone = null, 
        string $browser = "auto", 
        string $proxyManagedCountry = "br", 
        string $proxyManagedState = "sp", 
        string $proxyManagedCity = "campinas"
    ): InstanceData
    {
        $instanceEndpoint = new UazapiInstance($this->subdomain, $this->token);
        return $instanceEndpoint->connect($systemName, $phone, $browser, $proxyManagedCountry, $proxyManagedState, $proxyManagedCity);
    }

    public function instanceStatus(): InstanceStatusResponse
    {
        $instanceEndpoint = new UazapiInstance($this->subdomain, $this->token);
        return $instanceEndpoint->status();
    }

    public function deleteInstance(): bool
    {
        $instanceEndpoint = new UazapiInstance($this->subdomain, $this->token);
        return $instanceEndpoint->delete();
    }
    #endregion
}