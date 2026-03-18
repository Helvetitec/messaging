<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Webhooks;

use Exception;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\WebhookData;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Helvetitec\Messaging\Enums\Uazapi\WebhookEvent;
use Helvetitec\Messaging\Enums\Uazapi\WebhookMessage;

class UazapiWebhooks extends UazapiInstanceEndpoint
{
    /**
     * Returns a collection of WebhookData. Normally this will return exactly one webhook, but if setAdvanced was used
     * there can be more than one.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        $url = $this->root().'webhook';
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

        $webhooks = collect();
        foreach($response->json() as $webhook){
            $webhooks->add(new WebhookData($webhook));
        }
        return $webhooks;
    }

    /**
     * Sets the configuration of the default webhook. The array of events should be WebhookEvent objects or string,
     * the array of excludeMessage should be WebhookMessage or string. If you have more than one webhook, 
     * use the setAdvanced method.
     *
     * @param boolean $enabled
     * @param string $webhookUrl
     * @param array $events
     * @param array $excludeMessages
     * @return WebhookData
     */
    public function set(bool $enabled, string $webhookUrl, array $events, array $excludeMessages): WebhookData
    {
        $convertedEvents = [];
        $convertedExcludeMessages = [];
        foreach($events as $event){
            $convertedEvents[] = $event instanceof WebhookEvent ? $event->value : $event;
        }
        foreach($excludeMessages as $message){
            $convertedExcludeMessages[] = $message instanceof WebhookMessage ? $message->value : $message;
        }

        $url = $this->root().'webhook';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            "enabled" => $enabled,
            "url" => $webhookUrl,
            "events" => $convertedEvents,
            "excludeMessages" => $convertedExcludeMessages
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

        return new WebhookData($response->json()[0]);
    }

    public function setAdvanced(array $request)
    {
        $url = $this->root().'webhook';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $request);
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

        return new WebhookData($response->json()[0]);
    }
}