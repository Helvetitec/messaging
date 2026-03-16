<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Blocks;

use Exception;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;

class UazapiBlocks extends UazapiInstanceEndpoint
{
    /**
     * Blocks/Unblocks a contact and returns a list of blocked contacts.
     *
     * @param string $number
     * @param boolean $block Will be blocked if true and unblocked if false
     * @return array
     */
    public function blockContact(string $number, bool $block): array
    {
        $url = $this->root().'chat/block';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'number' => $number,
            'block' => $block
        ]);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Contact not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('blockList');
    }

    /**
     * Returns an array of blocked contacts as Jid.
     *
     * @return array
     */
    public function getBlockedContacts(): array
    {
        $url = $this->root().'chat/blocklist';
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

        return $response->json('blockList');
    }
}