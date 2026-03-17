<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Contacts;

use Exception;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\ContactResponse;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\NumberVerifyResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Nette\NotImplementedException;

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
            $contacts->add(new ContactResponse($contact));
        }
        return $contacts;
    }

    /**
     * Returns an array with a paginated list of contacts as collection and more informations about the pagination
     *
     * @param integer $page
     * @param integer $pageSize
     * @param integer $limit
     * @param integer $offset
     * @return array [contacts, pagination]
     */
    public function paginated(
        int $page, 
        int $pageSize, 
        int $limit, 
        int $offset
    ): array
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
            $contacts->add(new ContactResponse($contact));
        }
        
        return [
            'pagination' => $response->json('pagination'),
            'contacts' => $contacts
        ];
    }

    /**
     * Add a contact to Whatsapp with the following phone and name and return a ContactResponse
     *
     * @param string $phone
     * @param string $name
     * @return ContactResponse
     */
    public function add(string $phone, string $name): ContactResponse
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

        return new ContactResponse($response->json('contact'));
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
     * Returns the full chat informations with a number, returns array of the response at the moment.
     * @todo Add correct return format
     * @param string $number
     * @param boolean $preview
     * @return array
     */
    public function get(string $number, bool $preview)
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

        return $response->json();
    }

    /**
     * Verifies an array of numbers and returns a collection of NumberVerifyResponse objects.
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
            $verifiedNumbers->add(new NumberVerifyResponse($verifiedNumber));
        }
        return $verifiedNumbers;
    }
}