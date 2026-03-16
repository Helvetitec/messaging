<?php

namespace Helvetitec\Messaging\Whatsapp\DTOs;

use Exception;
use Helvetitec\Messaging\Enums\BulkMessageType;

class BulkMessageDto
{
    public readonly array $numbers;
    public readonly BulkMessageType $type;
    public readonly ?string $folder;
    public readonly int $delayMin;
    public readonly int $delayMax;
    public readonly int $scheduledFor;
    public readonly ?string $info;
    public readonly ?int $delay; //Fixed delay, will ignore delayMax/delayMin
    public readonly ?string $mentions;
    public readonly ?string $text;
    public readonly ?bool $linkPreview;
    public readonly ?string $linkPreviewTitle;
    public readonly ?string $linkPreviewDescription;
    public readonly ?string $linkPreviewImage;
    public readonly ?bool $linkPreviewLarge;
    public readonly ?string $file; //If image, video, audio, document
    public readonly ?string $docName; //If document
    public readonly ?string $fullName; //If contact
    public readonly ?string $phoneNumber; //If contact
    public readonly ?string $organization; //If contact
    public readonly ?string $email; //If contact
    public readonly ?string $url; //If contact
    public readonly ?int $latitude; //If location
    public readonly ?int $longitude; //If location
    public readonly ?string $name; //If location
    public readonly ?string $address; //If location
    public readonly ?string $footerText; //If list, button, poll or carousel
    public readonly ?string $buttonText; //If list, button, poll or carousel
    public readonly ?string $listButton; //If list
    public readonly ?int $selectableCount; //If poll
    public readonly ?array $choices; //If list, button, poll or carousel.
    public readonly ?string $imageButton; //If button

    /**
     * Convert data to an array usable by Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\BulkMessages\UazapiBulkMessages.
     *
     * @return array
     */
    public function to(): array
    {
        $content = [
            'numbers' => $this->numbers,
            'type' => $this->type->value,
            'folder' => $this->folder,
            'delayMin' => $this->delayMin,
            'delayMax' => $this->delayMax,
            'scheduled_for' => $this->scheduledFor,
            'info' => $this->info,
            'delay' => $this->delay,
            'mentions' => $this->mentions,
            'text' => $this->text,
            'linkPreview' => $this->linkPreview,
            'linkPreviewTitle' => $this->linkPreviewTitle,
            'linkPreviewDescription' => $this->linkPreviewDescription,
            'linkPreviewImage' => $this->linkPreviewImage,
            'linkPreviewLarge' => $this->linkPreviewLarge,
            'file' => $this->file,
            'docName' => $this->docName,
            'fullName' => $this->fullName,
            'phoneNumber' => $this->phoneNumber,
            'organization' => $this->organization,
            'email' => $this->email,
            'url' => $this->url,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'name' => $this->name,
            'address' => $this->address,
            'footerText' => $this->footerText,
            'buttonText' => $this->buttonText,
            'listButton' => $this->listButton,
            'selectableCount' => $this->selectableCount,
            'choices' => $this->choices,
            'imageButton' => $this->imageButton
        ];
        $content = array_filter($content, function ($value) {
            return $value !== null;
        });
        return $content;
    }

    private function __construct(array $data)
    {
        foreach($data as $key => $value){
            $this->{$key} = $value;
        }
    }

    public static function generateText(
        array $numbers,
        string $folder,
        int $delayMin,
        int $delayMax,
        int $scheduledFor,
        string $text,
        ?string $info = null,
        ?int $delay = null,
        ?string $mentions = null,
        ?bool $linkPreview = null,
        ?string $linkPreviewTitle = null,
        ?string $linkPreviewDescription = null,
        ?string $linkPreviewImage = null,
        ?bool $linkPreviewLarge = null,    
    ): BulkMessageDto
    {
        return new BulkMessageDto([
            'type' => BulkMessageType::TEXT,
            'numbers' => $numbers,
            'folder' => $folder,
            'delayMin' => $delayMin,
            'delayMax' => $delayMax,
            'scheduledFor' => $scheduledFor,
            'text' => $text,
            'info' => $info,
            'delay' => $delay,
            'mentions' => $mentions,
            'linkPreview' => $linkPreview,
            'linkPreviewTitle' => $linkPreviewTitle,
            'linkPreviewDescription' => $linkPreviewDescription,
            'linkPreviewImage' => $linkPreviewImage,
            'linkPreviewLarge' => $linkPreviewLarge
        ]);
    }

    public static function generateFile(
        array $numbers,
        string $folder,
        int $delayMin,
        int $delayMax,
        int $scheduledFor,
        string $file,
        BulkMessageType $type,
        ?string $text = null,
        ?string $docName = null,
        ?string $info = null,
        ?int $delay = null,
        ?string $mentions = null,
        ?bool $linkPreview = null,
        ?string $linkPreviewTitle = null,
        ?string $linkPreviewDescription = null,
        ?string $linkPreviewImage = null,
        ?bool $linkPreviewLarge = null,    
    ): BulkMessageDto
    {
        if(
            $type != BulkMessageType::AUDIO && 
            $type != BulkMessageType::DOCUMENT &&
            $type != BulkMessageType::IMAGE &&
            $type != BulkMessageType::VIDEO
        ){
            throw new Exception("Invalid type for generateFile. Valid Types: BulkMessageType::AUDIO, BulkMessageType::DOCUMENT, BulkMessageType::IMAGE, BulkMessageType::VIDEO");
        }

        return new BulkMessageDto([
            'type' => $type,
            'numbers' => $numbers,
            'folder' => $folder,
            'delayMin' => $delayMin,
            'delayMax' => $delayMax,
            'scheduledFor' => $scheduledFor,
            'file' => $file,
            'text' => $text,
            'docName' => $docName,
            'info' => $info,
            'delay' => $delay,
            'mentions' => $mentions,
            'linkPreview' => $linkPreview,
            'linkPreviewTitle' => $linkPreviewTitle,
            'linkPreviewDescription' => $linkPreviewDescription,
            'linkPreviewImage' => $linkPreviewImage,
            'linkPreviewLarge' => $linkPreviewLarge
        ]);
    }

    public static function generateContact(
        array $numbers,
        string $folder,
        int $delayMin,
        int $delayMax,
        int $scheduledFor,
        string $fullName,
        string $phoneNumber,
        ?string $organization = null,
        ?string $email = null,
        ?string $url = null,
        ?string $info = null,
        ?int $delay = null,
    ):BulkMessageDto
    {
        return new BulkMessageDto([
            'type' => BulkMessageType::CONTACT,
            'numbers' => $numbers,
            'folder' => $folder,
            'delayMin' => $delayMin,
            'delayMax' => $delayMax,
            'scheduledFor' => $scheduledFor,
            'fullName' => $fullName,
            'phoneNumber' => $phoneNumber,
            'organization' => $organization,
            'email' => $email,
            'url' => $url,
            'info' => $info,
            'delay' => $delay,
        ]);
    }

    public static function generateLocation(
        array $numbers,
        string $folder,
        int $delayMin,
        int $delayMax,
        int $scheduledFor,
        int $latitude,
        int $longitude,
        string $name,
        string $address,
        ?string $info = null,
        ?int $delay = null
    ): BulkMessageDto
    {
        return new BulkMessageDto([
            'type' => BulkMessageType::LOCATION,
            'numbers' => $numbers,
            'folder' => $folder,
            'delayMin' => $delayMin,
            'delayMax' => $delayMax,
            'scheduledFor' => $scheduledFor,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'name' => $name,
            'address' => $address,
            'info' => $info,
            'delay' => $delay,
        ]);
    }

    public static function generateList(
        array $numbers,
        string $folder,
        int $delayMin,
        int $delayMax,
        int $scheduledFor,
        ?string $footerText = null,
        ?string $buttonText = null,
        ?string $listButton = null,
        ?array $choices = null,
        ?string $info = null,
        ?int $delay = null
    ): BulkMessageDto
    {
        return new BulkMessageDto([
            'type' => BulkMessageType::LIST,
            'numbers' => $numbers,
            'folder' => $folder,
            'delayMin' => $delayMin,
            'delayMax' => $delayMax,
            'scheduledFor' => $scheduledFor,
            'footerText' => $footerText,
            'buttonText' => $buttonText,
            'listButton' => $listButton,
            'choices' => $choices,
            'info' => $info,
            'delay' => $delay,
        ]);
    }

    public static function generateButton(
        array $numbers,
        string $folder,
        int $delayMin,
        int $delayMax,
        int $scheduledFor,
        ?string $footerText = null,
        ?string $buttonText = null,
        ?array $choices = null,
        ?string $imageButton = null,
        ?string $info = null,
        ?int $delay = null
    ): BulkMessageDto
    {
        return new BulkMessageDto([
            'type' => BulkMessageType::BUTTON,
            'numbers' => $numbers,
            'folder' => $folder,
            'delayMin' => $delayMin,
            'delayMax' => $delayMax,
            'scheduledFor' => $scheduledFor,
            'footerText' => $footerText,
            'buttonText' => $buttonText,
            'imageButton' => $imageButton,
            'choices' => $choices,
            'info' => $info,
            'delay' => $delay,
        ]);
    }

    public static function generatePoll(
        array $numbers,
        string $folder,
        int $delayMin,
        int $delayMax,
        int $scheduledFor,
        array $choices,
        int $selectableCount,
        ?string $footerText = null,
        ?string $buttonText = null,
        ?string $info = null,
        ?int $delay = null
    ): BulkMessageDto
    {
        return new BulkMessageDto([
            'type' => BulkMessageType::POLL,
            'numbers' => $numbers,
            'folder' => $folder,
            'delayMin' => $delayMin,
            'delayMax' => $delayMax,
            'scheduledFor' => $scheduledFor,
            'selectableCount' => $selectableCount,
            'footerText' => $footerText,
            'buttonText' => $buttonText,
            'choices' => $choices,
            'info' => $info,
            'delay' => $delay,
        ]);
    }

    public static function generateCarousel(
        array $numbers,
        string $folder,
        int $delayMin,
        int $delayMax,
        int $scheduledFor,
        array $choices,
        ?string $footerText = null,
        ?string $buttonText = null,
        ?string $info = null,
        ?int $delay = null
    ): BulkMessageDto
    {
        return new BulkMessageDto([
            'type' => BulkMessageType::CAROUSEL,
            'numbers' => $numbers,
            'folder' => $folder,
            'delayMin' => $delayMin,
            'delayMax' => $delayMax,
            'scheduledFor' => $scheduledFor,
            'footerText' => $footerText,
            'buttonText' => $buttonText,
            'choices' => $choices,
            'info' => $info,
            'delay' => $delay,
        ]);
    }
}