<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class BusinessProductsData
{
    public readonly string $id;
    public readonly string $name;
    public readonly string $description;
    public readonly string $price;
    public readonly string $currency;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->price = $data['price'];
        $this->currency = $data['currency'];
    }
}