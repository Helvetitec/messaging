<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class ContactResponse
{
    public readonly string $jid;
    public readonly string $fullName;
    public readonly string $firstName;

    public function __construct(array $data)
    {
        $this->jid = $data['jid'];
        $this->fullName = $data['contactName'];
        $this->firstName = $data['contact_FirstName'];
    }
}