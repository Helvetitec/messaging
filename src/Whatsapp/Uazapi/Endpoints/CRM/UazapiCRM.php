<?php 

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\CRM;

use Exception;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Facades\Http;
use Nette\NotImplementedException;

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
     * rules than in updateCustomField.
     *
     * @param array $fields
     * @return void
     */
    public function updateCustomFields(array $fields)
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
     * Edit informations of the lead.
     * **NOT IMPLEMENTED**
     * @todo Add functionality
     * @return void
     */
    public function editLeadInformations()
    {
        throw new NotImplementedException();
    }
}