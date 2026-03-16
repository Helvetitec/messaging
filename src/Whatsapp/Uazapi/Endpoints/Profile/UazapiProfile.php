<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Profile;

use Exception;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;

final class UazapiProfile extends UazapiInstanceEndpoint
{
    /**
     * Changes the profile name visible for all contacts.
     *
     * @param string $name
     * @return boolean
     */
    public function changeProfileName(string $name): bool
    {
        $url = $this->root().'profile/name';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'name' => $name
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload!");
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Action not allowed!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Updates the profile picture. Needs to be an image of type JPEG and with a size of 640x640 pixels.
     *
     * @param string $image Url to image, base64 or 'remove' or 'delete'
     * @return bool
     */
    public function changeProfileImage(string $image): bool
    {
        $url = $this->root().'profile/image';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'image' => $image
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload!");
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Action not allowed!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }
}