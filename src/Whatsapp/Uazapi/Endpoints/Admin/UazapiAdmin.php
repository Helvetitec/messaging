<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Admin;

use Exception;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\InstanceData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\WebhookData;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiAdminEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class UazapiAdmin extends UazapiAdminEndpoint
{
    /**
     * Creates an instance and returns its Instance data
     *
     * @param string $name
     * @param string $systemName
     * @param string $fingerPrintProfile
     * @param string $browser
     * @param string|null $adminField01
     * @param string|null $adminField02
     * @return InstanceData
     */
    public function createInstance(
        string $name, 
        string $systemName = "apiLocal", 
        string $fingerPrintProfile = "chrome", 
        string $browser = "chrome", 
        ?string $adminField01 = null, 
        ?string $adminField02 = null
    ) : InstanceData
    {
        $url = $this->root().'instance/init';
        $response = Http::asJson()->withHeader('admintoken', $this->adminToken)->post($url, [
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

        return new InstanceData($response->json('instance'));
    }

    /**
     * Returns a collection of InstanceData objects created.
     *
     * @return Collection
     */
    public function listInstances(): Collection
    {
        $url = $this->root().'instance/all';
        $response = Http::withHeader('admintoken', $this->adminToken)->get($url);
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
            $instances->add(new InstanceData($instanceData));
        }

        return $instances;
    }

    /**
     * Updates the AdminField01 and AdminField02 from the instance where necessary and returns updated InstanceData.
     *
     * @param string $instanceId
     * @param string|null $adminField01
     * @param string|null $adminField02
     * @return InstanceData
     */
    public function updateAdminFields(string $instanceId, ?string $adminField01 = null, ?string $adminField02 = null): InstanceData
    {
        $url = $this->root().'instance/init';
        $response = Http::asJson()->withHeader('admintoken', $this->adminToken)->post($url, [
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

        return new InstanceData($response->json());
    }

    /**
     * Returns the informations of the Global Webhook
     *
     * @return WebhookData
     */
    public function showGlobalWebhook(): WebhookData
    {
        $url = $this->root().'globalwebhook';
        $response = Http::withHeader('admintoken', $this->adminToken)->get($url);
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
        return new WebhookData($response->json());
    }

    /**
     * Configure the global webhook
     *
     * @param string $url
     * @param array $events
     * @param array $excludedMessages
     * @return WebhookData
     */
    public function configGlobalWebhook(string $url, array $events, array $excludedMessages): WebhookData
    {
        $url = $this->root().'globalwebhook';
        $response = Http::asJson()->withHeader('admintoken', $this->adminToken)->post($url, [
             "url" => $url,
            "events" => $events,
            "excludeMessages" => $excludedMessages
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
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
        return new WebhookData($response->json());
    }

    /**
     * Restarts the application from the server. Only use this when really necessary!
     *
     * @return boolean
     */
    public function restartApplication(): bool
    {
        $url = $this->root().'admin/restart';
        $response = Http::asJson()->withHeader('admintoken', $this->adminToken)->post($url);
        return $response->successful();
    }
}