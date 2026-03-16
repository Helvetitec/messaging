<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Proxy;

use Exception;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\ProxyResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;

class UazapiProxy extends UazapiInstanceEndpoint
{
    /**
     * Returns a ProxyResponse object with the current configurations.
     *
     * @return ProxyResponse
     */
    public function getProxyConfigurations(): ProxyResponse
    {
        $url = $this->root().'instance/proxy';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $enabled = $response->json('enabled');
        $proxyUrl = $response->json('proxy_url');
        $lastTestAt = $response->json('last_test_at');
        $lastTestError = $response->json('last_test_error');
        $validationError = $response->json('validation_error');

        return new ProxyResponse(
            enabled: $enabled,
            proxyUrl: $proxyUrl,
            lastTestAt: $lastTestAt,
            lastTestError: $lastTestError,
            validationError: $validationError,
        );
    }

    /**
     * Updates the proxy configurations and returns the updated configurations as ProxyResponse.
     *
     * @param boolean $enable
     * @param string $proxyUrl
     * @return ProxyResponse
     */
    public function setProxyConfigurations(bool $enable, string $proxyUrl): ProxyResponse
    {
        $url = $this->root().'instance/proxy';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'enable' => $enable,
            'proxy_url' => $proxyUrl
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid paylout or proxy!");
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $proxy = $response->json('proxy');
        $enabled = $proxy['enabled'];
        $proxyUrl = $proxy['proxy_url'];
        $lastTestAt = $proxy['last_test_at'];
        $lastTestError = $proxy['last_test_error'];
        $validationError = $proxy['validation_error'];
        
        return new ProxyResponse(
            enabled: $enabled,
            proxyUrl: $proxyUrl,
            lastTestAt: $lastTestAt,
            lastTestError: $lastTestError,
            validationError: $validationError,
        );
    }

    /**
     * Deletes the current proxy configurtions for the instance.
     *
     * @return boolean
     */
    public function deleteProxyConfigurations(): bool
    {
        $url = $this->root().'instance/proxy';
        $response = Http::asJson()->withHeader('token', $this->token)->delete($url);
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }
}