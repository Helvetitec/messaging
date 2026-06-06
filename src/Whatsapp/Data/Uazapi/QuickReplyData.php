<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class QuickReplyData
{
    public readonly string $id;
    public readonly bool $onWhatsApp;
    public readonly string $docName;
    public readonly string $file;
    public readonly string $shortCut;
    public readonly string $text;
    public readonly string $type;
    public readonly string $owner;
    public readonly string $createdAt;
    public readonly string $updatedAt;

    /**
     * @param array{
     *  id: string,
     *  onWhatsApp: bool,
     *  docName: string,
     *  file: string,
     *  shortCut: string,
     *  text: string,
     *  type: string,
     *  owner: string,
     *  created: string,
     *  updated: string
     * } $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->onWhatsApp = $data['onWhatsApp'];
        $this->docName = $data['docName'];
        $this->file = $data['file'];
        $this->shortCut = $data['shortCut'];
        $this->text = $data['text'];
        $this->type = $data['type'];
        $this->owner = $data['owner'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['updated'];
    }
}