<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class NumberVerifyData
{
    public readonly string $query;
    public readonly string $jid;
    public readonly string $lid;
    public readonly bool $isInWhatsapp;
    public readonly string $verifiedName;
    public readonly string $groupName;
    public readonly string $error;

    public function __construct(array $data)
    {
        $this->query = $data['query'];
        $this->jid = $data['jid'];
        $this->lid = $data['lid'];
        $this->isInWhatsapp = $data['isInWhatsapp'];
        $this->verifiedName = $data['verifiedName'];
        $this->groupName = $data['groupName'];
        $this->error = $data['error'];
    }
}