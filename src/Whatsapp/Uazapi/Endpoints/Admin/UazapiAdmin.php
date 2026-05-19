<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Admin;

use Exception;
use Helvetitec\Messaging\Exceptions\HttpStatusException;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\InstanceData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\WebhookData;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\SystemStatusDto;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiAdminEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class UazapiAdmin extends UazapiAdminEndpoint
{
    /**
     * Creates an instance and returns its Instance data
     *
     * @param string $name
     * @param string|null $adminField01
     * @param string|null $adminField02
     * @return InstanceData
     */
    public function createInstance(
        string $name,
        ?string $adminField01 = null, 
        ?string $adminField02 = null
    ) : InstanceData
    {
        $url = $this->root().'instance/create';
        $response = Http::asJson()->withHeader('admintoken', $this->adminToken)->post($url, [
            "name" => $name,
            "adminField01" => $adminField01,
            "adminField02" => $adminField02
        ]);

        if(!$response->successful()){
            if($response->status() == 401){
                throw new HttpStatusException($response->status(), "[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 404){
                throw new HttpStatusException($response->status(), "[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new HttpStatusException($response->status(), "[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
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
                throw new HttpStatusException($response->status(), "[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new HttpStatusException($response->status(), "[UAZAPI] Admin token invalid!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new HttpStatusException($response->status(), "[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
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
                throw new HttpStatusException($response->status(), "[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new HttpStatusException($response->status(), "[UAZAPI] Admin token invalid!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new HttpStatusException($response->status(), "[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
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
                throw new HttpStatusException($response->status(), "[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new HttpStatusException($response->status(), "[UAZAPI] Admin token invalid!");
            }elseif($response->status() == 404){
                throw new HttpStatusException($response->status(), "[UAZAPI] No global webhook found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new HttpStatusException($response->status(), "[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
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
                throw new HttpStatusException($response->status(), "[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new HttpStatusException($response->status(), "[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 403){
                throw new HttpStatusException($response->status(), "[UAZAPI] Admin token invalid!");
            }elseif($response->status() == 404){
                throw new HttpStatusException($response->status(), "[UAZAPI] No global webhook found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new HttpStatusException($response->status(), "[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
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

    public function systemStatus(): SystemStatusDto
    {
        $url = $this->root().'status';
        $response = Http::get($url);

        if(!$response->successful()){
            $status = $response->status();
            $body = $response->body();
            throw new HttpStatusException($response->status(), "[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
        }
        $responseArr = $response->json();

        if(!$responseArr || !is_array($responseArr)){
            throw new Exception("[UAZAPI] Invalid return while checking system status for {$this->root()}: ".json_encode($responseArr));
        }

        $statusArr = $responseArr['status'];
        return new SystemStatusDto(
            ok: $statusArr['server_status'] == 'running',
            info: $responseArr['info'],
            dc: $statusArr['dc'],
            lastCheck: $statusArr['last_check'],
            serverStatus: $statusArr['server_status'],
            totalInstances: $statusArr['total_instances']
        ); 
    }
}