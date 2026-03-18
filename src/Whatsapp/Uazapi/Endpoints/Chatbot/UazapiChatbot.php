<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Chatbot;

use Exception;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\ChatbotAgentDto;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\ChatbotFunctionDto;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\ChatbotTriggerDto;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ChatbotAgentData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ChatbotFunctionData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ChatbotKnowledgeData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\ChatbotTriggerData;
use Helvetitec\Messaging\Whatsapp\Data\Uazapi\InstanceData;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UazapiChatbot extends UazapiInstanceEndpoint
{
    /**
     * Configure the Chatbot.
     *
     * @param string $openaiKey API key for OpenAI
     * @param boolean $enabled Enable chatbot
     * @param boolean $ignoreGroups Should the chatbot ignore groups?
     * @param string $stopConversation Command to stop the chatbot
     * @param integer $stopMinutes Minutes the chatbot will be stopped
     * @param integer $stopWhenYouSendMsg Should the chatbot stop when you send a message?
     * @return InstanceData
     */
    public function config(
        string $openaiKey, 
        bool $enabled, 
        bool $ignoreGroups, 
        string $stopConversation, 
        int $stopMinutes, 
        int $stopWhenYouSendMsg
    ): InstanceData
    {
        $url = $this->root().'instance/updatechatbotsettings';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            "openai_apikey" => $openaiKey,
            "chatbot_enabled" => $enabled,
            "chatbot_ignoreGroups" => $ignoreGroups,
            "chatbot_stopConversation" => $stopConversation,
            "chatbot_stopMinutes" => $stopMinutes,
            "chatbot_stopWhenYouSendMsg" => $stopWhenYouSendMsg
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
     * Create trigger from ChtabotTriggerDto data.
     *
     * @param ChatbotTriggerDto $triggerData
     * @return ChatbotTriggerData
     */
    public function createTrigger(ChatbotTriggerDto $triggerData): ChatbotTriggerData
    {
        $url = $this->root().'trigger/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'trigger' => $triggerData->to()
        ]);
        
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

        return new ChatbotTriggerData($response->json());
    }

    /**
     * Edit trigger with id from ChatbotTriggerDto data.
     *
     * @param string $id
     * @param ChatbotTriggerDto $triggerData
     * @return ChatbotTriggerData
     */
    public function editTrigger(string $id, ChatbotTriggerDto $triggerData): ChatbotTriggerData
    {
        $url = $this->root().'trigger/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'trigger' => $triggerData->to()
        ]);
        
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

        return new ChatbotTriggerData($response->json());
    }

    /**
     * Delete trigger with id.
     *
     * @param string $id
     * @return boolean
     */
    public function deleteTrigger(string $id): bool
    {
        $url = $this->root().'trigger/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'delete' => true
        ]);
        
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
        return true;
    }

    /**
     * List all triggers as a collection of ChatbotTriggerData.
     *
     * @return Collection
     */
    public function listTriggers(): Collection
    {
        $url = $this->root().'trigger/list';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);
        
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] No permissions!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $triggers = collect();
        foreach($response->json() as $trigger){
            $triggers->add(new ChatbotTriggerData($trigger));
        }
        return $triggers;
    }

    /**
     * Create agent from ChtabotAgentDto data.
     *
     * @param ChatbotAgentDto $agentData
     * @return ChatbotAgentData
     */
    public function createAgent(ChatbotAgentDto $agentData): ChatbotAgentData
    {
        $url = $this->root().'agent/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'agent' => $agentData->to()
        ]);
        
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

        return new ChatbotAgentData($response->json());
    }

    /**
     * Edit agent with id from ChatbotAgentDto data.
     *
     * @param string $id
     * @param ChatbotAgentDto $agentData
     * @return ChatbotAgentData
     */
    public function editAgent(string $id, ChatbotAgentDto $agentData): ChatbotAgentData
    {
        $url = $this->root().'agent/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'agent' => $agentData->to()
        ]);
        
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

        return new ChatbotAgentData($response->json());
    }

    /**
     * Delete agent with id.
     *
     * @param string $id
     * @return boolean
     */
    public function deleteAgent(string $id): bool
    {
        $url = $this->root().'agent/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'delete' => true
        ]);
        
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
        return true;
    }

    /**
     * List all agents as a collection of ChatbotAgentData.
     *
     * @return Collection
     */
    public function listAgents(): Collection
    {
        $url = $this->root().'agent/list';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);
        
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] No permissions!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $agents = collect();
        foreach($response->json() as $agent){
            $agents->add(new ChatbotAgentData($agent));
        }
        return $agents;
    }

    /**
     * Create knowledge.
     *
     * @param bool $active
     * @param string $title
     * @param mixed $content
     * @return ChatbotKnowledgeData
     */
    public function createKnowledgebase(bool $active, string $title, mixed $content): ChatbotKnowledgeData
    {
        $url = $this->root().'knowledge/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'knowledge' => [
                'active' => $active,
                'title' => $title,
                'content' => $content
            ]
        ]);
        
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

        return new ChatbotKnowledgeData($response->json());
    }

    /**
     * Edit knowledge with id.
     *
     * @param string $id
     * @param bool $active
     * @param string $title
     * @param mixed $content
     * @return ChatbotKnowledgeData
     */
    public function editKnowledgebase(string $id, bool $active, string $title, mixed $content): ChatbotKnowledgeData
    {
        $url = $this->root().'knowledge/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'knowledge' => [
                'active' => $active,
                'title' => $title,
                'content' => $content
            ]
        ]);
        
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

        return new ChatbotKnowledgeData($response->json());
    }

    /**
     * Delete knowledge with id.
     *
     * @param string $id
     * @return boolean
     */
    public function deleteKnowledgebase(string $id): bool
    {
        $url = $this->root().'knowledge/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'delete' => true
        ]);
        
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

        return true;
    }

    /**
     * List all knowledge as a collection of ChatbotKnowledgeData.
     *
     * @return Collection
     */
    public function listKnowledgebase()
    {
        $url = $this->root().'knowledge/list';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);
        
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] No permissions!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $knowledges = collect();
        foreach($response->json() as $knowledge){
            $knowledges->add(new ChatbotKnowledgeData($knowledge));
        }
        return $knowledges;
    }

    /**
     * Create function with id from ChatbotFunctionDto data.
     *
     * @param ChatbotFunctionDto $functionData
     * @return ChatbotFunctionData
     */
    public function createFunction(ChatbotFunctionDto $functionData): ChatbotFunctionData
    {
        $url = $this->root().'function/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'function' => $functionData->to()
        ]);
        
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

        return new ChatbotFunctionData($response->json());
    }

    /**
     * Edit function with id from ChatbotFunctionDto data.
     *
     * @param string $id
     * @param ChatbotFunctionDto $functionData
     * @return ChatbotFunctionData
     */
    public function editFunction(string $id, ChatbotFunctionDto $functionData): ChatbotFunctionData
    {
        $url = $this->root().'function/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'function' => $functionData->to()
        ]);
        
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

        return new ChatbotFunctionData($response->json());
    }

    /**
     * Delete function with id.
     *
     * @param string $id
     * @return boolean
     */
    public function deleteFunction(string $id): bool
    {
        $url = $this->root().'function/edit';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'id' => $id,
            'delete' => true
        ]);
        
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

        return true;
    }

    /**
     * List all functions as a collection of ChatbotFunctionData.
     *
     * @return Collection
     */
    public function listFunction()
    {
        $url = $this->root().'function/list';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);
        
        if(!$response->successful()){
            if($response->status() == 401){
                throw new Exception("[UAZAPI] No permissions!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        $functions = collect();
        foreach($response->json() as $function){
            $functions->add(new ChatbotFunctionData($function));
        }
        return $functions;
    }
}