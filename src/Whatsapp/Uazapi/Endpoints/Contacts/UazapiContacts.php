<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Contacts;

use Exception;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ChatData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ContactData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\NumberVerifyData;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\PaginatedResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UazapiContacts extends UazapiInstanceEndpoint
{
    /**
     * Returns a single collection with all contacts
     *
     * @return Collection
     */
    public function list(): Collection
    {
        $url = $this->root().'contacts';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $contacts = collect();
        foreach($response->json() as $contact){
            $contacts->add(new ContactData($contact));
        }
        return $contacts;
    }

    /**
     * Returns a PaginatedResponse  with a list of contacts as collection and more informations about the pagination
     *
     * @param integer $page
     * @param integer $pageSize
     * @param integer $limit
     * @param integer $offset
     * @return PaginatedResponse
     */
    public function paginated(
        int $page, 
        int $pageSize, 
        int $limit, 
        int $offset
    ): PaginatedResponse
    {
        $url = $this->root().'contacts/list';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'page' => $page,
            'pageSize' => $pageSize,
            'limit' => $limit,
            'offset' => $offset
        ]);

        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $contacts = collect();
        foreach($response->json('contacts') as $contact){
            $contacts->add(new ContactData($contact));
        }
        
        $pagination = $response->json('pagination');
        return new PaginatedResponse(
            items: $contacts,
            totalRecords: $pagination['totalRecords'],
            pageSize: $pagination['pageSize'],
            currentPage: $pagination['currentPage'],
            totalPages: $pagination['totalPages'],
            hasNextPage: $pagination['hasNextPage'],
            hasPreviousPage: $pagination['hasPreviousPage']
        );
    }

    /**
     * Add a contact to Whatsapp with the following phone and name and return a ContactData
     *
     * @param string $phone
     * @param string $name
     * @return ContactData
     */
    public function add(string $phone, string $name): ContactData
    {
        $url = $this->root().'contact/add';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'phone' => $phone,
            'name' => $name
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new ContactData($response->json('contact'));
    }

    /**
     * Deletes a contact from Whatsapp
     *
     * @param string $phone
     * @return boolean
     */
    public function delete(string $phone): bool
    {
        $url = $this->root().'contact/remove';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'phone' => $phone
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Returns the full chat informations with a number.
     * 
     * @param string $number
     * @param boolean $preview
     * @return ChatData
     */
    public function get(string $number, bool $preview): ChatData
    {
        $url = $this->root().'chat/details';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'number' => $number,
            'preview' => $preview
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new ChatData($response->json());
    }

    /**
     * Verifies an array of numbers and returns a collection of NumberVerifyData objects.
     *
     * @param array $numbers
     * @return Collection
     */
    public function verifyNumbers(array $numbers): Collection
    {
        $url = $this->root().'chat/check';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'numbers' => $numbers
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $verifiedNumbers = collect();
        foreach($response->json() as $verifiedNumber)
        {
            $verifiedNumbers->add(new NumberVerifyData($verifiedNumber));
        }
        return $verifiedNumbers;
    }
}