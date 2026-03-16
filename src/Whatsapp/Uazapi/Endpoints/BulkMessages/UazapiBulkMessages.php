<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\BulkMessages;

use Exception;
use Helvetitec\Messaging\Enums\BulkMessageAction;
use Helvetitec\Messaging\Enums\BulkMessageStatus;
use Helvetitec\Messaging\Whatsapp\DTOs\BulkMessageDto;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\BulkMessageResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Nette\NotImplementedException;

class UazapiBulkMessages extends UazapiInstanceEndpoint
{
    /**
     * Generates a BulkMessage with the informations from $dto and returns the folder_id if successful.
     *
     * @param BulkMessageDto $dto
     * @return string
     */
    public function create(BulkMessageDto $dto): string
    {
        $url = $this->root().'sender/simple';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $dto->to());
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid/Expired Token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Contact not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('folder_id');
    }

    /**
     * Create an advanced BulkMessage.
     * **NOT IMPLEMENTED**
     * 
     * @throws NotImplementedException
     */
    public function createAdvanced()
    {
        throw new NotImplementedException();
    }

    /**
     * Control BulkMessage with folderId.
     * Possible Actions: continue, stop, delete
     *
     * @param string $folderId
     * @param BulkMessageAction $action
     * @return boolean
     */
    public function control(string $folderId, BulkMessageAction $action): bool
    {
        $url = $this->root().'sender/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'folder_id' => $folderId,
            'action' => $action->value
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Cleans sent BulkMessages after $hours hours.
     *
     * @param integer $hours
     * @return array [messages_deleted, folders_deleted]
     */
    public function cleanSentMessages(int $hours = 168): array
    {
        $url = $this->root().'sender/cleardone';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'hours' => $hours
        ]);
        if(!$response->successful()){
            $status = $response->status();
            $body = $response->body();
            throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
        }
        return [
            'messages_deleted' => $response->json('messages_deleted'),
            'folders_deleted' => $response->json('folders_deleted')
        ];
    }

    /**
     * Deletes all BulkMessages and their messages.
     *
     * @return bool
     */
    public function deleteAll(): bool
    {
        $url = $this->root().'sender/clearall';
        $response = Http::asJson()->withHeader('token', $this->token)->delete($url);
        if(!$response->successful()){
            $status = $response->status();
            $body = $response->body();
            throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
        }
        return true;
    }

    /**
     * Shows details about a BulkMessage with a certain folderId or returns null.
     *
     * @param string $folderId
     * @return BulkMessageResponse|null
     */
    public function show(string $folderId): BulkMessageResponse|null
    {
        $bulkMessages = $this->list();
        return $bulkMessages->where('id', '=', $folderId)->first();
    }

    /**
     * Returns a list of all BulkMessages.
     *
     * @param BulkMessageStatus|null $status
     * @return Collection
     */
    public function list(?BulkMessageStatus $status = null): Collection
    {
        $url = $this->root().'sender/listfolders';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            'status' => $status
        ]);
        if(!$response->successful()){
            $status = $response->status();
            $body = $response->body();
            throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
        }
        $bulkMessages = collect();
        foreach($response->json() as $bulkMessage){
            $bulkMessages->add(new BulkMessageResponse($bulkMessage));
        }
        return $bulkMessages;
    }

    /**
     * Returns all messages from a specific BulkMessage.
     * 
     * @todo Add Message object, not only a collection of arrays.
     * @param string $folderId
     * @param string|null $messageStatus
     * @param integer|null $page
     * @param integer|null $pageSize
     * @return Collection
     */
    public function getMessages(string $folderId, ?string $messageStatus = null, ?int $page = null, ?int $pageSize = null): Collection
    {
        $url = $this->root().'sender/listfolders';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url,[
            "folder_id" => $folderId,
            "messageStatus" => $messageStatus,
            "page" => $page,
            "pageSize" => $pageSize
        ]);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return collect($response->json('messages'));
    }
}