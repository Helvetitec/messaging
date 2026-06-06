<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class BusinessProfileData
{
    public readonly string $tag;
    public readonly string $description;
    public readonly string $address;
    public readonly string $email;
    public readonly array $websites;
    public readonly array $categories;
    
    /**
     * @param array{
     *  tag: string,
     *  description: string,
     *  address: string,
     *  email: string,
     *  websites: array,
     *  categories: array
     * } $data
     */
    public function __construct(array $data)
    {
        $this->tag = $data['tag'];
        $this->description = $data['description'];
        $this->address = $data['address'];
        $this->email = $data['email'];
        $this->websites = $data['websites'];
        $this->categories = $data['categories'];
    }
}