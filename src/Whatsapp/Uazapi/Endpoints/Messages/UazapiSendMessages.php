<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Messages;

use Exception;
use Helvetitec\Messaging\Enums\Uazapi\MediaType;
use Helvetitec\Messaging\Enums\Uazapi\PixType;
use Helvetitec\Messaging\Enums\Uazapi\StoryMediaType;
use Helvetitec\Messaging\Enums\WhatsappPresence;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\MessageConfigDto;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;
use Nette\NotImplementedException;

class UazapiSendMessages extends UazapiInstanceEndpoint
{
    /**
     * Sends a text message with custom configuration and returns an array of the sent message.
     *
     * @todo Return correct format
     * @param string $number
     * @param string $text
     * @param boolean $linkPreview
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendText(string $number, string $text, bool $linkPreview, MessageConfigDto $messageConfig): array
    {
        $data = array_merge([
            'number' => $number,
            'text' => $text,
            'linkPreview' => $linkPreview
        ], $messageConfig->to());

        $url = $this->root().'send/text';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends an image from a file to a number with caption.
     *
     * @todo Return correct format
     * @param string $number
     * @param string $file
     * @param string $caption
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendImage(string $number, string $file, string $caption, MessageConfigDto $messageConfig): array
    {
        return $this->sendMedia($number, MediaType::IMAGE, $file, $caption, null, $messageConfig);
    }

    /**
     * Sends a video from a file to a number with caption
     *
     * @todo Return correct format
     * @param string $number
     * @param string $file
     * @param string $caption
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendVideo(string $number, string $file, string $caption, MessageConfigDto $messageConfig): array
    {
        return $this->sendMedia($number, MediaType::VIDEO, $file, $caption, null, $messageConfig);
    }

    /**
     * Sends an audio file to a number from a file.
     *
     * @todo Return correct format
     * @param string $number
     * @param string $file
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendAudio(string $number, string $file, MessageConfigDto $messageConfig): array
    {
        return $this->sendMedia($number, MediaType::AUDIO, $file, null, null, $messageConfig);
    }

    /**
     * Sends a MyAudio file from a file to a number.
     *
     * @todo Return correct format
     * @param string $number
     * @param string $file
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendMyAudio(string $number, string $file, MessageConfigDto $messageConfig): array
    {
        return $this->sendMedia($number, MediaType::MYAUDIO, $file, null, null, $messageConfig);
    }

    /**
     * Sends a Push-To-Talk message to a number
     *
     * @todo Return correct format
     * @param string $number
     * @param string $file
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendPtt(string $number, string $file, MessageConfigDto $messageConfig): array
    {
        return $this->sendMedia($number, MediaType::PTT, $file, null, null, $messageConfig);
    }

    /**
     * Sends a Push-To-Video to a number
     *
     * @todo Return correct format
     * @param string $number
     * @param string $file
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendPtv(string $number, string $file, MessageConfigDto $messageConfig): array
    {
        return $this->sendMedia($number, MediaType::PTV, $file, null, null, $messageConfig);
    }

    /**
     * Sends a sticker to a number
     *
     * @todo Return correct format
     * @param string $number
     * @param string $file
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendSticker(string $number, string $file, MessageConfigDto $messageConfig): array
    {
        return $this->sendMedia($number, MediaType::STICKER, $file, null, null, $messageConfig);
    }

    /**
     * Sends a document to a number with optional docName and caption.
     *
     * @todo Return correct format
     * @param string $number
     * @param string $file
     * @param string $docName
     * @param string $caption
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendDocument(string $number, string $file, string $docName, string $caption, MessageConfigDto $messageConfig): array
    {
        return $this->sendMedia($number, MediaType::DOCUMENT, $file, $caption, $docName, $messageConfig);
    }

    /**
     * Sends a media to a number. You can use sendDocument, sendImage etc. as this is easier than calling this directly.
     *
     * @todo Return correct format
     * @param string $number
     * @param MediaType $type
     * @param string $file
     * @param string|null $text
     * @param string|null $docName
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendMedia(string $number, MediaType $type, string $file, ?string $text = null, ?string $docName = null, MessageConfigDto $messageConfig): array
    {
        $data = array_merge([
            'number' => $number,
            'type' => $type->value,
            'file' => $file,
            'text' => $text,
            'docName' => $docName
        ], $messageConfig->to());

        $url = $this->root().'send/media';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 413){
                throw new Exception("[UAZAPI] File too big!");
            }elseif($response->status() == 415){
                throw new Exception("[UAZAPI] File format not supported!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a vCard with all informations to a number and returns an array of the message sent.
     *
     * @todo Return correct format
     * @param string $number
     * @param string $fullName
     * @param string $phoneNumber
     * @param string $organization
     * @param string $email
     * @param string $url
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendVCard(
        string $number, 
        string $fullName, 
        string $phoneNumber, 
        string $organization, 
        string $email, 
        string $url, 
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'number' => $number,
            'fullName' => $fullName,
            'phoneNumber' => $phoneNumber,
            'organization' => $organization,
            'email' => $email,
            'url' => $url
        ], $messageConfig->to());

        $url = $this->root().'send/contact';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a location with details 
     *
     * @param string $number
     * @param ?string $name
     * @param ?string $address
     * @param float $latitude
     * @param float $longitude
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendLocation(
        string $number, 
        float $latitude, 
        float $longitude, 
        ?string $name, 
        ?string $address, 
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'number' => $number,
            'name' => $name,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude
        ], $messageConfig->to());

        $url = $this->root().'send/location';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Updates the presence for a number for a certain duration in miliseconds.
     *
     * @param string $number
     * @param WhatsappPresence $presence
     * @param integer $durationInMs
     * @return true
     */
    public function updatePresence(string $number, WhatsappPresence $presence, int $durationInMs): true
    {
        $url = $this->root().'send/presence';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'number' => $number,
            'presence' => $presence->value,
            'delay' => $durationInMs
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Adds a new story and returns its content.
     *
     * @todo Return correct format
     * @param StoryMediaType $type
     * @param integer $backgroundColor
     * @param integer $font
     * @param string|null $text
     * @param string|null $file
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendStory(
        StoryMediaType $type, 
        int $backgroundColor, 
        int $font, 
        ?string $text, 
        ?string $file, 
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'type' => $type->value,
            'text' => $text,
            'background_color' => $backgroundColor,
            'font' => $font,
            'file' => $file
        ], $messageConfig->to());

        $url = $this->root().'send/status';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a button and returns the message as array.
     *
     * @param string $number
     * @param string $text
     * @param array $choices
     * @param string|null $footerText
     * @param string|null $imageButton
     * @param MessageConfigDto $messageConfig
     * @link https://docs.uazapi.com/endpoint/post/send~menu Documentation for how to set choices.
     * @return array
     */
    public function sendButton(
        string $number, 
        string $text, 
        array $choices, 
        ?string $footerText, 
        ?string $imageButton, 
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'number' => $number,
            'type' => 'button',
            'text' => $text,
            'choices' => $choices,
            'footerText' => $footerText,
            'imageButton' => $imageButton
        ], $messageConfig->to());

        $url = $this->root().'send/menu';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a carousel and returns the message as array.
     *
     * @param string $number
     * @param string $text
     * @param array $choices
     * @param MessageConfigDto $messageConfig
     * @link https://docs.uazapi.com/endpoint/post/send~menu Documentation for how to set choices.
     * @return array
     */
    public function sendCarousel(
        string $number, 
        string $text, 
        array $choices, 
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'number' => $number,
            'type' => 'carousel',
            'text' => $text,
            'choices' => $choices,
        ], $messageConfig->to());

        $url = $this->root().'send/menu';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a carousel with advanced options and returns the message as array. Read the documentation to see how it works.
     *
     * @todo Return correct format
     * @param string $number
     * @param string $text
     * @param array $carousel
     * @param MessageConfigDto $messageConfig
     * @link https://docs.uazapi.com/endpoint/post/send~carousel Documentation of the carousel array
     * @return array
     */
    public function sendAdvancedCarousel(
        string $number, 
        string $text, 
        array $carousel, 
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'number' => $number,
            'text' => $text,
            'carousel' => $carousel,
        ], $messageConfig->to());

        $url = $this->root().'send/carousel';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a list and returns the message as array.
     *
     * @param string $number
     * @param string $text
     * @param array $choices
     * @param string $listButton
     * @param string|null $footerText
     * @param MessageConfigDto $messageConfig
     * @link https://docs.uazapi.com/endpoint/post/send~menu Documentation for how to set choices.
     * @return void
     */
    public function sendList(string $number, string $text, array $choices, string $listButton, ?string $footerText, MessageConfigDto $messageConfig)
    {
        $data = array_merge([
            'number' => $number,
            'type' => 'list',
            'text' => $text,
            'choices' => $choices,
            'listButton' => $listButton,
            'footerText' => $footerText
        ], $messageConfig->to());

        $url = $this->root().'send/menu';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a poll and returns the message as an array.
     *
     * @param string $number
     * @param string $text
     * @param array $choices
     * @param integer $selectableCount
     * @param MessageConfigDto $messageConfig
     * @link https://docs.uazapi.com/endpoint/post/send~menu Documentation for how to set choices.
     * @return void
     */
    public function sendPoll(string $number, string $text, array $choices, int $selectableCount, MessageConfigDto $messageConfig)
    {
        $data = array_merge([
            'number' => $number,
            'type' => 'poll',
            'text' => $text,
            'choices' => $choices,
            'selectableCount' => $selectableCount
        ], $messageConfig->to());

        $url = $this->root().'send/menu';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a payment as PIX and returns the message as array.
     *
     * @param string $number
     * @param string $amount
     * @param string $text
     * @param string $pixKey
     * @param string $pixName
     * @param PixType $pixType
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendPixPayment(
        string $number, 
        string $amount, 
        string $text, 
        string $pixKey, 
        string $pixName,
        PixType $pixType, 
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'number' => $number,
            'amount' => (float)$amount,
            'text' => $text,
            'pixType' => $pixType->value,
            'pixName' => $pixName,
            'pixKey' => $pixKey,
        ], $messageConfig->to());

        $url = $this->root().'send/request-payment';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a payment as invoice and returns the message as array.
     *
     * @param string $number
     * @param string $amount
     * @param string $text
     * @param string $boletoCode
     * @param string $additionalNote
     * @param string $fileUrl
     * @param string $fileName
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendInvoicePayment(
        string $number, 
        string $amount,
        string $text,
        string $boletoCode,
        string $additionalNote,
        string $fileUrl,
        string $fileName,
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'number' => $number,
            'amount' => (float)$amount,
            'text' => $text,
            'boletoCode' => $boletoCode,
            'additionalNote' => $additionalNote,
            'fileUrl' => $fileUrl,
            'fileName' => $fileName,
        ], $messageConfig->to());

        $url = $this->root().'send/request-payment';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a payment with a link.
     * **NOT IMPLEMENTED**
     *
     * @param string $number
     * @param MessageConfigDto $messageConfig
     * @throws NotImplementedException
     */
    public function sendLinkPayment(string $number, MessageConfigDto $messageConfig)
    {
        throw new NotImplementedException();
    }

    /**
     * Sends a payment with invoice and PIX together and returns the message as array.
     *
     * @param string $number
     * @param string $amount
     * @param string $text
     * @param string $pixKey
     * @param PixType $pixType
     * @param string $pixName
     * @param string $boletoCode
     * @param string $additionalNote
     * @param string $fileUrl
     * @param string $fileName
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendCombinedPayment(
        string $number,
        string $amount,
        string $text,
        string $pixKey,
        PixType $pixType,
        string $pixName,
        string $boletoCode,
        string $additionalNote,
        string $fileUrl,
        string $fileName,
        MessageConfigDto $messageConfig
    ): array
    {
        $data = array_merge([
            'number' => $number,
            'amount' => (float)$amount,
            'text' => $text,
            'pixKey' => $pixKey,
            'pixType' => $pixType->value,
            'pixName' => $pixName,
            'boletoCode' => $boletoCode,
            'additionalNote' => $additionalNote,
            'fileUrl' => $fileUrl,
            'fileName' => $fileName,
        ], $messageConfig->to());

        $url = $this->root().'send/request-payment';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a Pix Button to a number and returns an array of the message.
     *
     * @todo Return correct format
     * @param string $number
     * @param PixType $pixType
     * @param string $pixKey
     * @param string|null $pixName
     * @param MessageConfigDto $messageConfig
     * @return array
     */
    public function sendPixButton(string $number, PixType $pixType, string $pixKey, ?string $pixName, MessageConfigDto $messageConfig): array
    {
        $data = array_merge([
            'number' => $number,
            'pixType' => $pixType->value,
            'pixKey' => $pixKey,
            'pixName' => $pixName,
        ], $messageConfig->to());

        $url = $this->root().'send/pix-button';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Sends a location button to a number with a custom text.
     *
     * @todo Return correct format
     * @param string $number
     * @param string $text
     * @param MessageConfigDto $messageConfig
     * @return void
     */
    public function requestLocation(string $number, string $text, MessageConfigDto $messageConfig)
    {
        $data = array_merge([
            'number' => $number,
            'text' => $text,
        ], $messageConfig->to());

        $url = $this->root().'send/location-button';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $data);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }
}