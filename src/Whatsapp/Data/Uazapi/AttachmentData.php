<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class AttachmentData
{
    public readonly ?string $fileUrl;
    public readonly ?string $mimeType;
    public readonly ?string $base64Data;
    public readonly ?string $transcription;

    /**
     * @param array{
     *  fileUrl?: string,
     *  mimeType?: string,
     *  base64Data?: string,
     *  transcription?: string
     * } $data
     */
    public function __construct(array $data)
    {
        $this->fileUrl = $data['fileUrl'] ?? null;
        $this->mimeType = $data['mimeType'] ?? null;
        $this->base64Data = $data['base64Data'] ?? null;
        $this->transcription = $data['transcription'] ?? null;
        
    }
}