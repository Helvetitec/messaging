<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Messages;

use Exception;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\AttachmentResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;

class UazapiMessages extends UazapiInstanceEndpoint
{
    /**
     * Downloads an attachment and returns an AttachmentResponse object.
     *
     * @param string $messageId
     * @return AttachmentResponse
     */
    public function downloadAttachment(string $messageId): AttachmentResponse
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

        return new AttachmentResponse($response->json());
    }

    /**
     * Downloads an attachment and returns an AttachmentResponse object with additional configurations.
     *
     * @param string $messageId
     * @param array $configurations
     * @link https://docs.uazapi.com/endpoint/post/message~download Documentation for additional configurations.
     * @return AttachmentResponse
     */
    public function advancedDownloadAttachment(string $messageId, array $configurations): AttachmentResponse
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

        return new AttachmentResponse($response->json());
    }

    public function loadMessagesFromChat()
    {

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