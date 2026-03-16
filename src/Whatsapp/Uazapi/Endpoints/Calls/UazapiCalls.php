<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Calls;

use Exception;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;

class UazapiCalls extends UazapiInstanceEndpoint
{
    /**
     * Makes a call to a certain number. When attending nothing will be heard from the other side.
     *
     * @param string $number
     * @return boolean
     */
    public function make(string $number): bool
    {
        $url = $this->root().'call/make';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'number' => $number
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
     * Rejects any incoming call or a specific if number is set.
     *
     * @param string|null $number
     * @return boolean
     */
    public function reject(?string $number = null): bool
    {
        $url = $this->root().'call/reject';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'number' => $number
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