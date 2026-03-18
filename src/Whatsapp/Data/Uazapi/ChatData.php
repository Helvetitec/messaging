<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class ChatData
{
    public readonly string $id;
    public readonly string $waFastId;
    public readonly string $waChatId;
    public readonly string $waChatLid;
    public readonly bool $waArchived;
    public readonly string $waContactName;
    public readonly string $waName;
    public readonly string $name;
    public readonly string $image;
    public readonly string $imagePreview;
    public readonly int $waEphemeralExpiration;
    public readonly bool $waIsBlocked;
    public readonly bool $waIsGroup;
    public readonly bool $waIsGroupAdmin;
    public readonly bool $waIsGroupAnnounce;
    public readonly bool $waIsGroupCommunity;
    public readonly bool $waIsGroupMember;
    public readonly bool $waIsPinned;
    public readonly array $waLabel;
    public readonly string $waLastMessageTextVote;
    public readonly string $waLastMessageType;
    public readonly int $waLastMessageTimestamp;
    public readonly string $waLastMessageSender;
    public readonly int $waMuteEndTime;
    public readonly string $owner;
    public readonly int $waUnreadCount;
    public readonly string $phone;
    public readonly string $commonGroups;
    public readonly string $leadName;
    public readonly string $leadFullName;
    public readonly string $leadEmail;
    public readonly string $leadPersonalId;
    public readonly string $leadStatus;
    public readonly array $leadTags;
    public readonly string $leadNotes;
    public readonly bool $leadIsTicketOpen;
    public readonly string $leadAssignedAttendantId;
    public readonly int $leadKanbanOrder;
    public readonly array $leadFields;
    public readonly int $chatbotAgentResetMemoryAt;
    public readonly string $chatbotLastTriggerId;
    public readonly int $chatbotLastTriggerAt;
    public readonly int $chatbotDisableUntil;

    public function __construct(array $payload)
    {
        $this->id = $payload['id'];
        $this->waFastId = $payload['wa_fastid'];
        $this->waChatId = $payload['wa_chatid'];
        $this->waChatLid = $payload['wa_chatlid'];
        $this->waArchived = $payload['wa_archived'];
        $this->waContactName = $payload['wa_contactName'];
        $this->waName = $payload['wa_name'];
        $this->name = $payload['name'];
        $this->image = $payload['image'];
        $this->imagePreview = $payload['imagePreview'];
        $this->waEphemeralExpiration = $payload['w_ephemeralExpiration'];
        $this->waIsBlocked = $payload['wa_isBlocked'];
        $this->waIsGroup = $payload['wa_isGroup'];
        $this->waIsGroupAdmin = $payload['wa_isGroup_admin'];
        $this->waIsGroupAnnounce = $payload['wa_isGroup_announce'];
        $this->waIsGroupCommunity = $payload['wa_isGroup_community'];
        $this->waIsGroupMember = $payload['wa_isGroup_member'];
        $this->waIsPinned = $payload['wa_isPinned'];
        $this->waLabel = $payload['wa_label'];
        $this->waLastMessageTextVote = $payload['wa_lastMessageTextVote'];
        $this->waLastMessageType = $payload['wa_lastMessageType'];
        $this->waLastMessageTimestamp = $payload['wa_lastMsgTimestamp'];
        $this->waLastMessageSender = $payload['wa_lastMessageSender'];
        $this->waMuteEndTime = $payload['wa_muteEndTime'];
        $this->owner = $payload['owner'];
        $this->waUnreadCount = $payload['wa_unreadCount'];
        $this->phone = $payload['phone'];
        $this->commonGroups = $payload['common_groups'];
        $this->leadName = $payload['lead_name'];
        $this->leadFullName = $payload['lead_fullName'];
        $this->leadEmail = $payload['lead_email'];
        $this->leadPersonalId = $payload['lead_personalid'];
        $this->leadStatus = $payload['lead_status'];
        $this->leadTags = $payload['lead_tags'];
        $this->leadNotes = $payload['lead_notes'];
        $this->leadIsTicketOpen = $payload['lead_isTicketOpen'];
        $this->leadAssignedAttendantId = $payload['lead_assignedAttendant_id'];
        $this->leadKanbanOrder = $payload['lead_kanbanOrder'];
        $this->leadFields = $this->convertLeadFields($payload);
        $this->chatbotAgentResetMemoryAt = $payload['chatbot_agentResetMemoryAt'];
        $this->chatbotLastTriggerId = $payload['chatbot_lastTrigger_id'];
        $this->chatbotLastTriggerAt = $payload['chatbot_lastTriggerAt'];
        $this->chatbotDisableUntil = $payload['chatbot_disableUntil'];
    }

    private function convertLeadFields($data): array{
        $fields = [];
        for($i=1; $i <= 20; $i++){ 
            $fieldName = 'lead_field'.($i < 10 ? '0'.$i : $i);
            $fields[$i] = $data[$fieldName] ?? null;
        }
        return $fields;
    }
}