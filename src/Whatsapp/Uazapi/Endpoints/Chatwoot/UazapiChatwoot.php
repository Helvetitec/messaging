<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Chatwoot;

use Exception;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ChatwootData;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;

class UazapiChatwoot extends UazapiInstanceEndpoint
{
    /**
     * Returns the chatwoot configurations as ChatwootData.
     *
     * @return ChatwootData
     */
    public function get(): ChatwootData
    {
        $url = $this->root().'chatwoot/config';
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
        return new ChatwootData($response->json());
    }

    /**
     * Sets the Chatwoot configuration and returns the Inbox url to put into your webhook settings.
     *
     * @param boolean $enabled
     * @param string $url
     * @param string $accessToken
     * @param integer $accountId
     * @param integer $inboxId
     * @param boolean $ignoreGroups
     * @param boolean $signMessages
     * @param boolean $createNewConversation
     * @return string
     */
    public function set(
        bool $enabled, 
        string $url, 
        string $accessToken, 
        int $accountId, 
        int $inboxId, 
        bool $ignoreGroups, 
        bool $signMessages, 
        bool $createNewConversation
    ): string
    {
        $url = $this->root().'chatwoot/config';
        $response = Http::asJson()->withHeader('token', $this->token)->put($url, [
            "enabled" => $enabled,
            "url" => $url,
            "access_token" => $accessToken,
            "account_id" => $accountId,
            "inbox_id" => $inboxId,
            "ignore_groups" => $ignoreGroups,
            "sign_messages" => $signMessages,
            "create_new_conversation" => $createNewConversation
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

        return $response->json('chatwoot_inbox_webhook_url');
    }
}