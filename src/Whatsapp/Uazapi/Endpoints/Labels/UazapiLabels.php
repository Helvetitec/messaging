<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Labels;

use Exception;
use Helvetitec\Messaging\Whatsapp\Responses\Uazapi\LabelResponse;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UazapiLabels extends UazapiInstanceEndpoint
{
    /**
     * Set the selected labels for the number.
     *
     * @param string $number
     * @param array $labelIds
     * @return true
     */
    public function setForNumber(string $number, array $labelIds): true
    {
        $url = $this->root().'chat/labels';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'number' => $number,
            'labelids' => $labelIds
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Chat not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Add a specific label to a number
     *
     * @param string $number
     * @param string $labelId
     * @return true
     */
    public function addToNumber(string $number, string $labelId): true
    {
        $url = $this->root().'chat/labels';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'number' => $number,
            'add_labelid' => $labelId
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Chat not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Remove a specific label from a number
     *
     * @param string $number
     * @param string $labelId
     * @return true
     */
    public function removeFromNumber(string $number, string $labelId): true
    {
        $url = $this->root().'chat/labels';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'number' => $number,
            'remove_labelid' => $labelId
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Chat not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Edit the name and color of a specific label.
     *
     * @param string $labelId
     * @param string $name
     * @param integer $color
     * @return void
     */
    public function edit(string $labelId, string $name, int $color)
    {
        if($color < 0 || $color > 19){
            throw new Exception("The color value needs to be between 0-19!");
        }

        $url = $this->root().'label/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'labelid' => $labelId,
            'name' => $name,
            'color' => $color
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
     * Delete a specific label.
     *
     * @param string $labelId
     * @return void
     */
    public function delete(string $labelId)
    {
        $url = $this->root().'label/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'labelid' => $labelId,
            'delete' => true
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
     * Returns a collection of LabelResponse objects.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        $url = $this->root().'labels';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);
        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }
        $labels = collect();
        foreach($response->json() as $label){
            $labels->add(new LabelResponse($label));
        }
        return $labels;
    }
}