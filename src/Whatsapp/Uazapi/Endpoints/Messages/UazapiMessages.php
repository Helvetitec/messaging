<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Messages;

use Exception;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\AttachmentData;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;

class UazapiMessages extends UazapiInstanceEndpoint
{
    /**
     * Downloads an attachment and returns an AttachmentData object.
     *
     * @param string $messageId
     * @return AttachmentData
     */
    public function downloadAttachment(string $messageId): AttachmentData
    {
        $url = $this->root().'message/download';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $messageId
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Attachment or message not found!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new AttachmentData($response->json());
    }

    /**
     * Downloads an attachment and returns an AttachmentData object with additional configurations.
     *
     * @param string $messageId
     * @param array $configurations
     * @link https://docs.uazapi.com/endpoint/post/message~download Documentation for additional configurations.
     * @return AttachmentData
     */
    public function advancedDownloadAttachment(string $messageId, array $configurations): AttachmentData
    {
        $url = $this->root().'message/download';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, array_merge([
            'id' => $messageId
        ], $configurations));

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Attachment or message not found!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Request limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new AttachmentData($response->json());
    }

    public function loadMessagesFromChat(string $chatId, int $limit, int $offset)
    {
        $url = $this->root().'message/find';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'chatid' => $chatId,
            'limit' => $limit,
            'offset' => $offset
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Chat not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }
    }

    public function markRead()
    {

    }

    public function sendReaction()
    {

    }

    public function deleteMessage()
    {

    }

    public function editMessage()
    {

    }
}