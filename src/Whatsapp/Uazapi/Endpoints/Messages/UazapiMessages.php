<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Messages;

use Exception;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\AttachmentData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\MessageData;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\LoadMessagesResponse;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\MarkReadResponse;
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

    /**
     * Fetches the messages from a chat and returns a LoadMessagesResponse with a messages
     * collection containing MessageData items and other informations.
     *
     * @param string $chatId
     * @param integer $limit
     * @param integer $offset
     * @return LoadMessagesResponse
     */
    public function loadMessagesFromChat(string $chatId, int $limit, int $offset): LoadMessagesResponse
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

        $messages = collect();
        foreach($response->json('messages') as $message){
            $messages->add(new MessageData($message));
        }

        return new LoadMessagesResponse(
            messages: $messages,
            returnedMessages: $response->json('returnedMessages'),
            limit: $response->json('limit'),
            offset: $response->json('offset'),
            nextOffset: $response->json('nextOffset'),
            hasMore: $response->json('hasMore'),
        );
    }

    /**
     * Load messages with track source and track id and returns a LoadMessagesResponse.
     *
     * @param string $trackSource
     * @param string $trackId
     * @param integer $limit
     * @param integer $offset
     * @return LoadMessagesResponse
     */
    public function loadTrackedMessages(string $trackSource, string $trackId, int $limit, int $offset): LoadMessagesResponse
    {
        $url = $this->root().'message/find';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'track_source' => $trackSource,
            'track_id' => $trackId,
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

        $messages = collect();
        foreach($response->json('messages') as $message){
            $messages->add(new MessageData($message));
        }

        return new LoadMessagesResponse(
            messages: $messages,
            returnedMessages: $response->json('returnedMessages'),
            limit: $response->json('limit'),
            offset: $response->json('offset'),
            nextOffset: $response->json('nextOffset'),
            hasMore: $response->json('hasMore'),
        );
    }

    /**
     * Loads a message with the specific messageId and returns its MessageData.
     *
     * @param string $messageId
     * @return MessageData
     */
    public function loadMessage(string $messageId): MessageData
    {
        $url = $this->root().'message/find';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'id' => $messageId
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

        return new MessageData($response->json('messages')[0]);
    }

    /**
     * Mark an array of message ids as read and will return a MarkReadResponse.
     *
     * @param array $messageIds
     * @return MarkReadResponse
     */
    public function markRead(array $messageIds): MarkReadResponse
    {
        $url = $this->root().'message/markread';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'id' => $messageIds
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
        
        return new MarkReadResponse(
            results: $response->json('results')
        );
    }

    /**
     * Sends a reaction and returns its messageid.
     *
     * @param string $number
     * @param string $reaction
     * @param string $messageId
     * @return string
     */
    public function sendReaction(string $number, string $reaction, string $messageId): string
    {
        $url = $this->root().'message/react';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'number' => $number,
            'text' => $reaction,
            'id' => $messageId
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Message not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('messageid');
    }

    /**
     * Deletes a message.
     *
     * @param string $messageId
     * @return true
     */
    public function deleteMessage(string $messageId): true
    {
        $url = $this->root().'message/delete';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'id' => $messageId
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Message not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Edits a message and returns the new messageid.
     *
     * @param string $messageId
     * @param string $text
     * @return string
     */
    public function editMessage(string $messageId, string $text): string
    {
        $url = $this->root().'message/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'id' => $messageId,
            'text' => $text
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Message not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('messageid');
    }
}