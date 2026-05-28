<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

use Helvetitec\Messaging\Enums\WhatsappMessageType;

class MessageData
{
    /**
     * Intern message Id
     *
     * @var string
     */
    public readonly string $id;
    /**
     * Original message Id
     *
     * @var string
     */
    public readonly string $messageId;
    /**
     * Id of the related chat
     *
     * @var string
     */
    public readonly string $chatId;
    /**
     * Id of the sender of the message
     *
     * @var string
     */
    public readonly string $sender;
    /**
     * Name of the sender of the message
     *
     * @var string
     */
    public readonly string $senderName;
    /**
     * Is the message from a group?
     *
     * @var boolean
     */
    public readonly bool $isGroup;
    /**
     * Is the message from the Instance?
     *
     * @var boolean
     */
    public readonly bool $fromMe;
    /**
     * Type of the content of the message. Will try to cast to WhatsappMessageType but will use string if type was not found
     *
     * @var WhatsappMessageType|string
     */
    public readonly WhatsappMessageType|string $messageType;
    /**
     * Origin platform of the message
     *
     * @var string
     */
    public readonly string $source;
    /**
     * Message timestamp in milliseconds
     *
     * @var integer
     */
    public readonly int $messageTimestamp;
    /**
     * Status of the lifecycle of the message
     *
     * @var string
     */
    public readonly string $status;
    /**
     * Original text of the message
     *
     * @var string
     */
    public readonly string $text;
    /**
     * Id of the quoted message
     *
     * @var string
     */
    public readonly string $quoted;
    /**
     * History of the edits of the message
     *
     * @var string
     */
    public readonly string $edited;
    /**
     * Id of the reacted message
     *
     * @var string
     */
    public readonly string $reaction;
    /**
     * Voting data from the list or poll
     *
     * @var ?string
     */
    public readonly ?string $vote;
    /**
     * Conversion of the options of the message, list, poll and button
     *
     * @var string
     */
    public readonly string $convertOptions;
    /**
     * Id of the selected/pressed button or item in the list
     *
     * @var ?string
     */
    public readonly ?string $buttonOrListId;
    /**
     * Owner of the message
     *
     * @var string
     */
    public readonly string $owner;
    /**
     * Error message in case it failed
     *
     * @var ?string
     */
    public readonly ?string $error;
    /**
     * Full content of the message, serialized json or plain text
     *
     * @var array
     */
    public readonly array $content;
    /**
     * Was the message sent by the API?
     *
     * @var ?boolean
     */
    public readonly ?bool $wasSentByApi;
    /**
     * Function used to send the message, if sent by API
     *
     * @var ?string
     */
    public readonly ?string $sendFunction;
    /**
     * Payload sent. Serialized JSON or plain text
     *
     * @var ?string
     */
    public readonly ?string $sendPayload;
    /**
     * Url or reference to the messages attachment
     *
     * @var ?string
     */
    public readonly ?string $fileUrl;
    /**
     * Folder if message was sent as mass message
     *
     * @var ?string
     */
    public readonly ?string $sendFolderId;
    /**
     * Tracking source for CRM
     *
     * @var string
     */
    public readonly string $trackSource;
    /**
     * Tracking Id for CRM
     *
     * @var string
     */
    public readonly string $trackId;
    /**
     * Metadata of the AI processing
     *
     * @var ?array
     */
    public readonly ?array $aiMetadata;
    /**
     * Resolved PN/JID of the sender
     *
     * @var ?string
     */
    public readonly ?string $senderPn;
    /**
     * LID of the sender
     *
     * @var ?string
     */
    public readonly ?string $senderLid;

    /**
     * Construct Message Data
     *
     * @param array{
     *  id: string,
     *  messageid: string,
     *  chatid: string,
     *  sender: string,
     *  senderName: string,
     *  isGroup: bool,
     *  fromMe: bool,
     *  messageType: string,
     *  source: string,
     *  messageTimestamp: int,
     *  status: string,
     *  text: string,
     *  quoted: string,
     *  edited: string,
     *  reaction: string,
     *  vote?: string,
     *  convertOptions: string,
     *  buttonOrListId?: string,
     *  owner: string,
     *  error?: string,
     *  content: array,
     *  wasSentByApi?: bool,
     *  sendFunction?: string,
     *  sendPayload?: string,
     *  fileUrl?: string,
     *  send_folder_id?: string,
     *  track_source: string,
     *  track_id: string,
     *  ai_metadata?: array,
     *  sender_pn?: string,
     *  sender_lid?: string
     * } $payload
     */
    public function __construct(array $payload)
    {
        $this->id = $payload['id'];
        $this->messageId = $payload['messageid'];
        $this->chatId = $payload['chatid'];
        $this->sender = $payload['sender'];
        $this->senderName = $payload['senderName'];
        $this->isGroup = $payload['isGroup'];
        $this->fromMe = $payload['fromMe'];
        $this->messageType = WhatsappMessageType::tryFrom(lcfirst($payload['messageType'])) ?? $payload['messageType'];
        $this->source = $payload['source'];
        $this->messageTimestamp = $payload['messageTimestamp'];
        $this->status = $payload['status'];
        $this->text = $payload['text'];
        $this->quoted = $payload['quoted'];
        $this->edited = $payload['edited'];
        $this->reaction = $payload['reaction'];
        $this->vote = $payload['vote'] ?? null;
        $this->convertOptions = $payload['convertOptions'];
        $this->buttonOrListId = $payload['buttonOrListId'] ?? null;
        $this->owner = $payload['owner'];
        $this->error = $payload['error'] ?? null;
        $this->content = $payload['content'];
        $this->wasSentByApi = $payload['wasSentByApi'] ?? null;
        $this->sendFunction = $payload['sendFunction'] ?? null;
        $this->sendPayload = $payload['sendPayload'] ?? null;
        $this->fileUrl = $payload['fileUrl'] ?? null;
        $this->sendFolderId = $payload['send_folder_id'] ?? null;
        $this->trackSource = $payload['track_source'];
        $this->trackId = $payload['track_id'];
        $this->aiMetadata = $payload['ai_metadata'] ?? null;
        $this->senderPn = $payload['sender_pn'] ?? null;
        $this->senderLid = $payload['sender_lid'] ?? null;
    }
}
