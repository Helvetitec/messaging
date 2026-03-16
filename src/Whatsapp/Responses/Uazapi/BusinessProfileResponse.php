<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class BusinessProfileResponse
{
    public readonly string $tag;
    public readonly string $description;
    public readonly string $address;
    public readonly string $email;
    public readonly array $websites;
    public readonly array $categories;
    
    public function __construct($data)
    {
        foreach($data as $key => $value){
            $this->{$key} = $value;
        }
    }
}