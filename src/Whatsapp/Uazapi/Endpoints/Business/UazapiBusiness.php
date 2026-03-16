<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Business;

use Exception;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\BusinessProductsResponse;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\BusinessProfileResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UazapiBusiness extends UazapiInstanceEndpoint
{
    /**
     * Get the commercial profile of a certain JID.
     *
     * @param string $jid
     * @return BusinessProfileResponse
     */
    public function getProfile(string $jid): BusinessProfileResponse
    {
        $url = $this->root().'business/get/profile';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'jid' => $jid
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }
        $responseArr = $response->json('response');
        return new BusinessProfileResponse([
            $responseArr['tag'],
            $responseArr['description'],
            $responseArr['address'],
            $responseArr['email'],
            $responseArr['websites'],
            $responseArr['categories']
        ]);
    }

    /**
     * Updates the business profile and returns false if not all fields have been updated.
     *
     * @param string|null $description
     * @param string|null $address
     * @param string|null $email
     * @return boolean
     */
    public function updateProfile(?string $description, ?string $address, ?string $email): bool
    {
        $url = $this->root().'business/update/profile';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'description' => $description,
            'address' => $address,
            'email' => $email
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }
        return $response->status() == 200;
    }

    /**
     * Get all the categories from the connected business profile as array ['id', 'localized_display_name']
     *
     * @return array
     */
    public function getCategories(): array
    {
        $url = $this->root().'business/get/categories';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('response');
    }

    /**
     * Get all products as collection from a specific Jid.
     *
     * @param string $jid
     * @return Collection
     */
    public function getProducts(string $jid): Collection
    {
        $url = $this->root().'business/catalog/list';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'jid' => $jid
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }
        $responseArr = $response->json('response');
        $products = collect();
        foreach($responseArr as $product){
            $products->add(new BusinessProductsResponse($product));
        }
        return $products;
    }

    /**
     * Get a specific product per Id and Jid as BusinessProductsResponse.
     *
     * @param string $jid
     * @param string $id
     * @return BusinessProductsResponse
     */
    public function getProduct(string $jid, string $id): BusinessProductsResponse
    {
        $url = $this->root().'business/catalog/info';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'jid' => $jid,
            'id' => $id,
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new BusinessProductsResponse($response->json('response'));
    }

    /**
     * Delete the product from the catalog.
     *
     * @param string $id
     * @return boolean
     */
    public function deleteProduct(string $id): bool
    {
        $url = $this->root().'business/catalog/delete';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Show the product inside the catalog
     *
     * @param string $id
     * @return boolean
     */
    public function showProduct(string $id): bool
    {
        $url = $this->root().'business/catalog/show';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Hide the product inside the catalog.
     *
     * @param string $id
     * @return boolean
     */
    public function hideProduct(string $id): bool
    {
        $url = $this->root().'business/catalog/hide';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }
}