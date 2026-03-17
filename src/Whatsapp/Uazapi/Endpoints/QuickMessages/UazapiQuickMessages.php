<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\QuickMessages;

use Exception;
use Helvetitec\Messaging\Enums\Uazapi\QuickMessageType;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\QuickMessageResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UazapiQuickMessages extends UazapiInstanceEndpoint
{
    /**
     * Adds a new QuickMessage and returns a QuickMessageResponse with its details
     *
     * @param string $shortCut
     * @param QuickMessageType $type
     * @param string|null $text
     * @param string|null $file
     * @param string|null $docName
     * @return QuickMessageResponse
     */
    public function add(string $shortCut, QuickMessageType $type, ?string $text = null, ?string $file = null, ?string $docName = null): QuickMessageResponse
    {
        if($type == QuickMessageType::TEXT && empty($text)){
            throw new Exception('QuickMessage of type QuickMessageType::TEXT need to contain the $text parameter');
        }elseif($type != QuickMessageType::TEXT && empty($file)){
            throw new Exception('QuickMessage not of type QuickMessageType::TEXT need to contain the $file parameter');
        }

        $url = $this->root().'quickreply/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'shortCut' => $shortCut,
            'type' => $type,
            'text' => $text,
            'file' => $file,
            'docName' => $docName
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Cant edit template made with Whatsapp!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new QuickMessageResponse($response->json('quickReplies')[0] ?? []);
    }

    /**
     * Updates a QuickMessage and returns a QuickMessageResponse with its updated data, but can't update the ones made in Whatsapp.
     *
     * @param string $id
     * @param string $shortCut
     * @param QuickMessageType $type
     * @param string|null $text
     * @param string|null $file
     * @param string|null $docName
     * @return QuickMessageResponse
     */
    public function update(string $id, string $shortCut, QuickMessageType $type, ?string $text = null, ?string $file = null, ?string $docName = null): QuickMessageResponse
    {
        if($type == QuickMessageType::TEXT && empty($text)){
            throw new Exception('QuickMessage of type QuickMessageType::TEXT need to contain the $text parameter');
        }elseif($type != QuickMessageType::TEXT && empty($file)){
            throw new Exception('QuickMessage not of type QuickMessageType::TEXT need to contain the $file parameter');
        }

        $url = $this->root().'quickreply/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'shortCut' => $shortCut,
            'type' => $type,
            'text' => $text,
            'file' => $file,
            'docName' => $docName
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Cant edit template made with Whatsapp!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new QuickMessageResponse($response->json('quickReplies')[0] ?? []);
    }

    /**
     * Deletes a QuickMessage, but can't delete the ones made in Whatsapp.
     *
     * @param string $id
     * @return true
     */
    public function delete(string $id): true
    {
        $url = $this->root().'quickreply/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'delete' => true
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Cant edit template made with Whatsapp!");
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
     * Lists all QuickMessages and returns them as a collection of QuickMessageResponse.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        $url = $this->root().'quickreply/showall';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);

        if(!$response->successful()){
            $status = $response->status();
            $body = $response->body();
            throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
        }

        $quickMessages = collect();
        foreach($response->json() as $quickMessage){
            $quickMessages->add(new QuickMessageResponse($quickMessage));
        }
        return $quickMessages;
    }
}