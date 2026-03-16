<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Admin;

use Exception;
use Helvetitec\Messaging\Whatsapp\Instances\UazapiInstance;
use Helvetitec\Messaging\Whatsapp\Responses\CreateInstanceResponse;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\GlobalWebhookResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiAdminEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class UazapiAdmin extends UazapiAdminEndpoint
{
    /**
     * Creates an instance and returns its token and qrcode if possible
     *
     * @param string $name
     * @param string $systemName
     * @param string $fingerPrintProfile
     * @param string $browser
     * @param string|null $adminField01
     * @param string|null $adminField02
     * @return CreateInstanceResponse
     */
    public static function createInstance(
        string $name, 
        string $systemName = "apiLocal", 
        string $fingerPrintProfile = "chrome", 
        string $browser = "chrome", 
        ?string $adminField01 = null, 
        ?string $adminField02 = null
    ) : CreateInstanceResponse
    {
        $url = self::root().'instance/init';
        $response = Http::asJson()->withHeader('admintoken', self::$adminToken)->post($url, [
            "name" => $name,
            "systemName" => $systemName,
            "adminField01" => $adminField01,
            "adminField02" => $adminField02,
            "fingerprintProfile" => $fingerPrintProfile,
            "browser" => $browser
        ]);

        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $token = (string)$response->json('token', null);
        $instance = (array)$response->json('instance', []);
        $qrcode = $instance['qrcode'] ?? null;
        $paircode = $instance['paircode'] ?? null;
        if(is_null($token)){
            throw new Exception("[UAZAPI] Invalid token for instance {$name}!");
        }

        return new CreateInstanceResponse(
            token: $token,
            qrcode: $qrcode,
            paircode: $paircode,
            instance: new UazapiInstance($instance)
        );
    }

    /**
     * Returns a collection of Helvetitec\Messaging\Whatsapp\Instances\UazapiInstance objects created.
     *
     * @return Collection
     */
    public static function listInstances(): Collection
    {
        $url = self::root().'instance/all';
        $response = Http::withHeader('admintoken', self::$adminToken)->get($url);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Admin token invalid!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $instancesData = (array)$response->json();
        $instances = collect();
        foreach($instancesData as $instanceData)
        {
            $instances->add(new UazapiInstance($instanceData));
        }

        return $instances;
    }

    /**
     * Updates the AdminField01 and AdminField02 from the instance where necessary and returns updated UazapiInstance.
     *
     * @param string $instanceId
     * @param string|null $adminField01
     * @param string|null $adminField02
     * @return UazapiInstance
     */
    public static function updateAdminFields(string $instanceId, ?string $adminField01 = null, ?string $adminField02 = null): UazapiInstance
    {
        $url = self::root().'instance/init';
        $response = Http::asJson()->withHeader('admintoken', self::$adminToken)->post($url, [
            "id" => $instanceId,
            "adminField01" => $adminField01,
            "adminField02" => $adminField02
        ]);

        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Admin token invalid!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new UazapiInstance($response->json());
    }

    /**
     * Returns the informations of the Global Webhook
     *
     * @return GlobalWebhookResponse
     */
    public static function showGlobalWebhook(): GlobalWebhookResponse
    {
        $url = self::root().'globalwebhook';
        $response = Http::withHeader('admintoken', self::$adminToken)->get($url);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Admin token invalid!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] No global webhook found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }
        return new GlobalWebhookResponse($response->json());
    }

    /**
     * Configure the global webhook
     *
     * @param string $url
     * @param array $events
     * @param array $excludedMessages
     * @return GlobalWebhookResponse
     */
    public static function configGlobalWebhook(string $url, array $events, array $excludedMessages): GlobalWebhookResponse
    {
        $url = self::root().'globalwebhook';
        $response = Http::asJson()->withHeader('admintoken', self::$adminToken)->post($url, [
             "url" => $url,
            "events" => $events,
            "excludeMessages" => $excludedMessages
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload!");
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Admin token invalid!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] No global webhook found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }
        return new GlobalWebhookResponse($response->json());
    }

    /**
     * Restarts the application from the server. Only use this when really necessary!
     *
     * @return boolean
     */
    public static function restartApplication(): bool
    {
        $url = self::root().'admin/restart';
        $response = Http::asJson()->withHeader('admintoken', self::$adminToken)->post($url);
        return $response->successful();
    }
}