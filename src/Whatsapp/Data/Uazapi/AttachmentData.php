<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class AttachmentData
{
    public readonly ?string $fileUrl;
    public readonly ?string $mimeType;
    public readonly ?string $base64Data;
    public readonly ?string $transcription;

    public function __construct($data)
    {
        $this->fileUrl = $data['fileUrl'] ?? null;
        $this->mimeType = $data['mimeType'] ?? null;
        $this->base64Data = $data['base64Data'] ?? null;
        $this->transcription = $data['transcription'] ?? null;
        
    }
}