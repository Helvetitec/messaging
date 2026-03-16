<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

class BusinessProductsResponse
{
    public readonly string $id;
    public readonly string $name;
    public readonly string $description;
    public readonly string $price;
    public readonly string $currency;

    public function __construct($data)
    {
        foreach($data as $key => $value){
            $this->{$key} = $value;
        }
    }
}