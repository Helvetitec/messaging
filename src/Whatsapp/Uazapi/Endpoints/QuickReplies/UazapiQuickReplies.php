<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\QuickReplys;

use Exception;
use Helvetitec\Messaging\Enums\Uazapi\QuickReplyType;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\QuickReplyData;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UazapiQuickReplies extends UazapiInstanceEndpoint
{
    /**
     * Adds a new QuickReply and returns a QuickReplyData with its details
     *
     * @param string $shortCut
     * @param QuickReplyType $type
     * @param string|null $text
     * @param string|null $file
     * @param string|null $docName
     * @return QuickReplyData
     */
    public function add(string $shortCut, QuickReplyType $type, ?string $text = null, ?string $file = null, ?string $docName = null): QuickReplyData
    {
        if($type == QuickReplyType::TEXT && empty($text)){
            throw new Exception('QuickReply of type QuickReplyType::TEXT need to contain the $text parameter');
        }elseif($type != QuickReplyType::TEXT && empty($file)){
            throw new Exception('QuickReply not of type QuickReplyType::TEXT need to contain the $file parameter');
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

        return new QuickReplyData($response->json('quickReplies')[0] ?? []);
    }

    /**
     * Updates a QuickReply and returns a QuickReplyData with its updated data, but can't update the ones made in Whatsapp.
     *
     * @param string $id
     * @param string $shortCut
     * @param QuickReplyType $type
     * @param string|null $text
     * @param string|null $file
     * @param string|null $docName
     * @return QuickReplyData
     */
    public function update(string $id, string $shortCut, QuickReplyType $type, ?string $text = null, ?string $file = null, ?string $docName = null): QuickReplyData
    {
        if($type == QuickReplyType::TEXT && empty($text)){
            throw new Exception('QuickReply of type QuickReplyType::TEXT need to contain the $text parameter');
        }elseif($type != QuickReplyType::TEXT && empty($file)){
            throw new Exception('QuickReply not of type QuickReplyType::TEXT need to contain the $file parameter');
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

        return new QuickReplyData($response->json('quickReplies')[0] ?? []);
    }

    /**
     * Deletes a QuickReply, but can't delete the ones made in Whatsapp.
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
     * Lists all QuickReplys and returns them as a collection of QuickReplyData.
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

        $QuickReplys = collect();
        foreach($response->json() as $QuickReply){
            $QuickReplys->add(new QuickReplyData($QuickReply));
        }
        return $QuickReplys;
    }
}