<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Chats;

use Exception;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ChatData;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UazapiChats extends UazapiInstanceEndpoint
{
    /**
     * Deletes chat from number
     *
     * @param string $number
     * @param boolean $deleteChatFromDb
     * @param boolean $deleteMessagesFromDb
     * @param boolean $deleteChatFromWhatsapp
     * @return boolean
     */
    public function delete(string $number, bool $deleteChatFromDb = true, bool $deleteMessagesFromDb = true, bool $deleteChatFromWhatsapp = true): bool
    {
        $url = $this->root().'chat/delete';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            "number" => $number,
            "deleteChatDB" => $deleteChatFromDb,
            "deleteMessagesDB" => $deleteMessagesFromDb,
            "deleteChatWhatsApp" => $deleteChatFromWhatsapp
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    public function archive(string $number, bool $archive): bool
    {
        $url = $this->root().'chat/archive';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            "number" => $number,
            "archive" => $archive
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    public function markAsRead(string $number, bool $read): bool
    {   
        $url = $this->root().'chat/read';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            "number" => $number,
            "read" => $read
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Mutes a selected chat.
     * Valid muteEndTime: Any positive number. 0 Removes mute. -1 sets mute to forever.
     *
     * @param string $number
     * @param integer $muteEndTime
     * @return boolean
     */
    public function mute(string $number, int $muteEndTime): bool
    {
        $url = $this->root().'chat/mute';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            "number" => $number,
            "muteEndTime" => $muteEndTime
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    public function pin(string $number, bool $pin)
    {
        $url = $this->root().'chat/pin';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            "number" => $number,
            "pin" => $pin
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Search the chats with a certain body and returns a collection of ChatData.
     *
     * @param array $body
     * @return Collection
     */
    public function search(array $body): Collection
    {
        $url = $this->root().'chat/find';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $body);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $chats = collect();
        foreach($response->json('chats') as $chat)
        {
            $chats->add(new ChatData($chat));
        }
        return $chats;
    }
}