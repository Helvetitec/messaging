<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Instance;

use Exception;
use Helvetitec\Messaging\Enums\WhatsappPresence;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\InstanceData;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\InstanceStatusResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;
use Nette\NotImplementedException;

final class UazapiInstance extends UazapiInstanceEndpoint
{
    /**
     * Connects the instance to Whatsapp. If $phone is not null, it will fetch a pairing code.
     *
     * @param string|null $phone
     * @return InstanceData
     */
    public function connect(?string $phone = null): InstanceData
    {
        $requestArray = [];
        if(!empty($phone)){
            $requestArray['phone'] = $phone;
        }
        $url = $this->root().'instance/connect';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $requestArray);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Max instances on server reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new InstanceData($response->json('instance'));
    }

    /**
     * Disconnects the instance from Whatsapp. A reconnect is necessary after this point.
     *
     * @return InstanceData
     */
    public function disconnect(): InstanceData
    {
        $url = $this->root().'instance/disconnect';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url);
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
     * Returns the status of the instance with additional informations. You can also access the qrcode from here with instance.qrcode.
     *
     * @return InstanceStatusResponse
     */
    public function status(): InstanceStatusResponse
    {
        $url = $this->root().'instance/status';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url);
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

        $instance = new InstanceData($response->json('instance'));
        $status = $response->json('status');

        return new InstanceStatusResponse(
            instance: $instance,
            status: $status
        );
    }

    /**
     * Updates the name of the instance
     *
     * @param string $newName
     * @return InstanceData
     */
    public function updateName(string $newName): InstanceData
    {
        $url = $this->root().'instance/updateInstanceName';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'name' => $newName
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
        return new InstanceData($response->json());
    }

    /**
     * Deletes an instance from the server.
     *
     * @return boolean
     */
    public function delete(): bool
    {
        $url = $this->root().'instance';
        $response = Http::asJson()->withHeader('token', $this->token)->delete($url);
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
        return true;
    }

    /**
     * Returns privacy settings
     *
     * @todo Implement funcionality
     * @return void
     */
    public function getPrivacySettings()
    {
        throw new NotImplementedException();
    }

    /**
     * Sets privacy settings
     *
     * @todo Implement funcionality
     * @return void
     */
    public function setPrivacySettings()
    {
        throw new NotImplementedException();
    }

    /**
     * Updates the presence of the instance.
     *
     * @param WhatsappPresence $presence
     * @return boolean
     */
    public function setPresence(WhatsappPresence $presence): bool
    {
        $url = $this->root().'instance/presence';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'presence' => $presence->value
        ]);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid presence value!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Sets the min and max delay between messages in seconds. Use 0 for no delay
     *
     * @param integer $minDelay
     * @param integer $maxDelay
     * @return InstanceData
     */
    public function setMessageDelay(int $minDelay, int $maxDelay): InstanceData
    {
        $url = $this->root().'instance/updateDelaySettings';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'msg_delay_min' => $minDelay,
            'msg_delay_max' => $maxDelay
        ]);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid request for message delay!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }
        return new InstanceData($response->json('instance'));
    }
}