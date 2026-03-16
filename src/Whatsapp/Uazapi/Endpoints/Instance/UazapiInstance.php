<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Instance;

use Exception;
use Helvetitec\Messaging\Enums\WhatsappPresence;
use Helvetitec\Messaging\Whatsapp\Instances\UazapiInstance as UazapiInstanceObject;
use Helvetitec\Messaging\Whatsapp\Responses\ConnectInstanceResponse;
use Helvetitec\Messaging\Whatsapp\Responses\InstanceStatusResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;
use Nette\NotImplementedException;

final class UazapiInstance extends UazapiInstanceEndpoint
{
    /**
     * Connects the instance to Whatsapp. If $phone is not null, it will fetch a pairing code.
     *
     * @param string|null $phone
     * @return ConnectInstanceResponse
     */
    public static function connect(?string $phone = null): ConnectInstanceResponse
    {
        $requestArray = [];
        if(!empty($phone)){
            $requestArray['phone'] = $phone;
        }
        $url = self::root().'instance/connect';
        $response = Http::asJson()->withHeader('token', self::$token)->post($url, $requestArray);
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

        $connected = $response->json('connected');
        $loggedIn = $response->json('loggedIn');
        $jid = $response->json('jid');
        $instance = new UazapiInstanceObject($response->json('instance'));

        return new ConnectInstanceResponse(
            connected: $connected,
            loggedIn: $loggedIn,
            jid: $jid,
            instance: $instance
        );
    }

    /**
     * Disconnects the instance from Whatsapp. A reconnect is necessary after this point.
     *
     * @return UazapiInstanceObject
     */
    public static function disconnect(): UazapiInstanceObject
    {
        $url = self::root().'instance/disconnect';
        $response = Http::asJson()->withHeader('token', self::$token)->post($url);
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
        return new UazapiInstanceObject($response->json('instance'));
    }

    /**
     * Returns the status of the instance with additional informations. You can also access the qrcode from here with instance.qrcode.
     *
     * @return InstanceStatusResponse
     */
    public static function status(): InstanceStatusResponse
    {
        $url = self::root().'instance/status';
        $response = Http::asJson()->withHeader('token', self::$token)->post($url);
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

        $instance = new UazapiInstanceObject($response->json('instance'));
        $connected = $response->json('status')['connected'] ?? null;
        $loggedIn = $response->json('status')['loggedIn'] ?? null;
        $jid = $response->json('status')['jid'] ?? null;

        return new InstanceStatusResponse(
            instance: $instance,
            connected: $connected,
            loggedIn: $loggedIn,
            jid: $jid
        );
    }

    /**
     * Updates the name of the instance
     *
     * @param string $newName
     * @return UazapiInstanceObject
     */
    public static function updateName(string $newName): UazapiInstanceObject
    {
        $url = self::root().'instance/updateInstanceName';
        $response = Http::asJson()->withHeader('token', self::$token)->post($url,[
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
        return new UazapiInstanceObject($response->json());
    }

    /**
     * Deletes an instance from the server.
     *
     * @return boolean
     */
    public static function delete(): bool
    {
        $url = self::root().'instance';
        $response = Http::asJson()->withHeader('token', self::$token)->delete($url);
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
    public static function getPrivacySettings()
    {
        throw new NotImplementedException();
    }

    /**
     * Sets privacy settings
     *
     * @todo Implement funcionality
     * @return void
     */
    public static function setPrivacySettings()
    {
        throw new NotImplementedException();
    }

    /**
     * Updates the presence of the instance.
     *
     * @param WhatsappPresence $presence
     * @return boolean
     */
    public static function setPresence(WhatsappPresence $presence): bool
    {
        $url = self::root().'instance/presence';
        $response = Http::asJson()->withHeader('token', self::$token)->post($url,[
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
     * @return UazapiInstanceObject
     */
    public static function setMessageDelay(int $minDelay, int $maxDelay): UazapiInstanceObject
    {
        $url = self::root().'instance/updateDelaySettings';
        $response = Http::asJson()->withHeader('token', self::$token)->post($url,[
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
        return new UazapiInstanceObject($response->json('instance'));
    }
}