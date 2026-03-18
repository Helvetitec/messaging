<?php 

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\CRM;

use Exception;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ChatData;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\CRMLeadDto;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;

class UazapiCRM extends UazapiInstanceEndpoint
{
    /**
     * Updates a single field and returns an array of fieldsMap [lead_field01, lead_field02, ...].
     * When updating more than one field, use updateCustomFields instead, as it is more performant.
     *
     * @param integer $id
     * @param string $content
     * @return array
     */
    public function updateCustomField(int $id, string $content): array
    {
        if($id < 1 || $id > 20){
            throw new Exception("Invalid ID value. Custom field id must be a value between 1-20");
        }
        $key = $id < 10 ? '0'.$id : ''.$id;
        if(strlen($content) > 255){
            throw new Exception("Invalid custom field value. The custom field value can't be more than 255 characters.");
        }

        $url = $this->root().'instance/updateFieldsMap';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'lead_field_'.$key
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('instance')['fieldsMap'] ?? null;
    }

    /**
     * Updates several custom CRM fields at once. The content inside the array should be [int, string] and have the same
     * rules than in updateCustomField. This method will return an array of the fieldmap.
     *
     * @param array $fields
     * @return array
     */
    public function updateCustomFields(array $fields): array
    {
        $convertedFields = [];
        foreach($fields as $id => $content)
        {
            if(!is_int($id)){
                throw new Exception("The key needs to be an integer vaue between 1-20");
            }
            if($id < 1 || $id > 20){
                throw new Exception("Invalid ID value. Custom field id must be a value between 1-20");
            }
            $key = $id < 10 ? '0'.$id : ''.$id;
            if(strlen($content) > 255){
                throw new Exception("Invalid custom field value. The custom field value can't be more than 255 characters.");
            }

            $convertedFields[$key] = $content;
        }

        $url = $this->root().'instance/updateFieldsMap';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $convertedFields);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('instance')['fieldsMap'] ?? null;
    }

    /**
     * Edit all lead informations and returns ChatData.
     * 
     * @param CRMLeadDto $leadData
     * @return ChatData
     */
    public function editLeadInformations(CRMLeadDto $leadData): ChatData
    {
        $url = $this->root().'chat/editLead';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, $leadData->to());
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Instance not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return new ChatData($response->json());
    }
}