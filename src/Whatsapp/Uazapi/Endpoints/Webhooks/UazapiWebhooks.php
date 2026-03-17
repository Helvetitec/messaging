<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Webhooks;

use Exception;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\WebhookResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Helvetitec\Messaging\Enums\Uazapi\WebhookEvent;
use Helvetitec\Messaging\Enums\Uazapi\WebhookMessage;

class UazapiWebhooks extends UazapiInstanceEndpoint
{
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
            $webhooks->add(new WebhookResponse($webhook));
        }
        return $webhooks;
    }

    public function set(bool $enabled, string $webhookUrl, array $events, array $excludeMessages)
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

        return new WebhookResponse($response->json()[0]);
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

        return new WebhookResponse($response->json()[0]);
    }
}