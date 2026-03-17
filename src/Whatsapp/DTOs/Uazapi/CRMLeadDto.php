<?php

namespace Helvetitec\Messaging\Whatsapp\DTOs\Uazapi;

use Exception;

class CRMLeadDto
{
    public readonly string $id;
    public readonly ?int $chatbotDisableUntil;
    public readonly ?bool $isTicketOpen;
    public readonly ?string $assignedAttendantId;
    public readonly ?int $kanbanOrder;
    public readonly ?array $leadTags;
    public readonly ?string $name;
    public readonly ?string $fullName;
    public readonly ?string $email;
    public readonly ?string $personalId;
    public readonly ?string $status;
    public readonly ?string $notes;
    public readonly ?array $fields;

    public function __construct(
        string $id,
        ?int $chatbotDisableUntil = null,
        ?bool $isTicketOpen = null,
        ?string $assignedAttendantId = null,
        ?int $kanbanOrder = null,
        ?array $leadTags = null,
        ?string $name = null,
        ?string $fullName = null,
        ?string $email = null,
        ?string $personalId = null,
        ?string $status = null,
        ?string $notes = null,
        ?array $fields = null
    )
    {
        $this->id = $id;
        $this->chatbotDisableUntil = $chatbotDisableUntil;
        $this->isTicketOpen = $isTicketOpen;
        $this->assignedAttendantId = $assignedAttendantId;
        $this->kanbanOrder = $kanbanOrder;
        $this->leadTags = $leadTags;
        $this->name = $name;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->personalId = $personalId;
        $this->status = $status;
        $this->notes = $notes;
        $this->fields = $fields;
    }

    public function to(): array
    {
        $convertedFields = [];
        foreach($this->fields as $id => $content)
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

        return array_merge($convertedFields,[
            "id" => $this->id,
            "chatbot_disableUntil" => $this->chatbotDisableUntil,
            "lead_isTicketOpen" => $this->isTicketOpen,
            "lead_assignedAttendant_id" => $this->assignedAttendantId,
            "lead_kanbanOrder" => $this->kanbanOrder,
            "lead_tags" => $this->leadTags,
            "lead_name" => $this->name,
            "lead_fullName" => $this->fullName,
            "lead_email" => $this->email,
            "lead_personalid" => $this->personalId,
            "lead_status" => $this->status,
            "lead_notes" => $this->notes,
        ]);
    }
}