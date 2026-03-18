<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class ChatData
{
    /**
     * Unique random id
     *
     * @var string
     */
    public readonly string $id;
    /**
     * Fast identifier from Whatsapp
     *
     * @var string
     */
    public readonly string $waFastId;
    /**
     * Complete chat id from Whatsapp
     *
     * @var string
     */
    public readonly string $waChatId;
    /**
     * Lid from chat from Whatsapp. (If avaiable)
     *
     * @var string
     */
    public readonly string $waChatLid;
    /**
     * Is the chat archived?
     *
     * @var boolean
     */
    public readonly bool $waArchived;
    /**
     * Name of the contact in Whatsapp
     *
     * @var string
     */
    public readonly string $waContactName;
    /**
     * Name of the Whatsapp
     *
     * @var string
     */
    public readonly string $waName;
    /**
     * Name shown in chat.
     *
     * @var string
     */
    public readonly string $name;
    /**
     * Url to the image of the chat.
     *
     * @var string
     */
    public readonly string $image;
    /**
     * Url to the thumbnail of the chat.
     *
     * @var string
     */
    public readonly string $imagePreview;
    /**
     * Ephemeral message expiration
     *
     * @var integer
     */
    public readonly int $waEphemeralExpiration;
    /**
     * Is the contact blocked?
     *
     * @var boolean
     */
    public readonly bool $waIsBlocked;
    /**
     * Is the chat a group?
     *
     * @var boolean
     */
    public readonly bool $waIsGroup;
    /**
     * Is the user a group admin?
     *
     * @var boolean
     */
    public readonly bool $waIsGroupAdmin;
    /**
     * Is the group only for announcements?
     *
     * @var boolean
     */
    public readonly bool $waIsGroupAnnounce;
    /**
     * Is the group a community?
     *
     * @var boolean
     */
    public readonly bool $waIsGroupCommunity;
    /**
     * Is the owner a group member?
     *
     * @var boolean
     */
    public readonly bool $waIsGroupMember;
    /**
     * Is the chat pinned?
     *
     * @var boolean
     */
    public readonly bool $waIsPinned;
    /**
     * Chat labels as array
     *
     * @var array
     */
    public readonly array $waLabel;
    /**
     * Text/Vote of the last message
     *
     * @var string
     */
    public readonly string $waLastMessageTextVote;
    /**
     * Type of the last message.
     *
     * @var string
     */
    public readonly string $waLastMessageType;
    /**
     * Timestamp of the last message.
     *
     * @var integer
     */
    public readonly int $waLastMessageTimestamp;
    /**
     * Sender of the last message
     *
     * @var string
     */
    public readonly string $waLastMessageSender;
    /**
     * Timestamp of the end of the mute.
     *
     * @var integer
     */
    public readonly int $waMuteEndTime;
    /**
     * Owner of the instance
     *
     * @var string
     */
    public readonly string $owner;
    /**
     * Amount of unread messages
     *
     * @var integer
     */
    public readonly int $waUnreadCount;
    /**
     * Phone number of the chat
     *
     * @var string
     */
    public readonly string $phone;
    /**
     * Groups in common separated by ","
     *
     * @var string
     */
    public readonly string $commonGroups;
    /**
     * Name of the lead
     *
     * @var string
     */
    public readonly string $leadName;
    /**
     * Full name of the lead
     *
     * @var string
     */
    public readonly string $leadFullName;
    /**
     * Email of the lead
     *
     * @var string
     */
    public readonly string $leadEmail;
    /**
     * Document of the lead
     *
     * @var string
     */
    public readonly string $leadPersonalId;
    /**
     * Status of the lead
     *
     * @var string
     */
    public readonly string $leadStatus;
    /**
     * Tags of the lead
     *
     * @var array
     */
    public readonly array $leadTags;
    /**
     * Notes of the lead
     *
     * @var string
     */
    public readonly string $leadNotes;
    /**
     * Is a ticket open with the lead?
     *
     * @var boolean
     */
    public readonly bool $leadIsTicketOpen;
    /**
     * Assigned attendant id of the lead
     *
     * @var string
     */
    public readonly string $leadAssignedAttendantId;
    /**
     * Kanban order of the lead
     *
     * @var integer
     */
    public readonly int $leadKanbanOrder;
    /**
     * Lead fields as an array.
     * lead_field01 = [1 => 'content']
     *
     * @var array
     */
    public readonly array $leadFields;
    /**
     * Timestamp of the last memory reset of the chatbot
     *
     * @var integer
     */
    public readonly int $chatbotAgentResetMemoryAt;
    /**
     * Id of the last trigger called
     *
     * @var string
     */
    public readonly string $chatbotLastTriggerId;
    /**
     * Timestamp of the last trigger called
     *
     * @var integer
     */
    public readonly int $chatbotLastTriggerAt;
    /**
     * Timestamp until the chatbot stays disabled.
     *
     * @var integer
     */
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