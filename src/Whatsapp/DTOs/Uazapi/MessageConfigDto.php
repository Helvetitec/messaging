<?php

namespace Helvetitec\Messaging\Whatsapp\DTOs\Uazapi;

class MessageConfigDto
{
    /**
     * Delay in miliseconds until message is sent. A 'writing...' or 'composing...' is shown during this time.
     *
     * @var integer|null
     */
    public ?int $delay = null;
    /**
     * Should the chat be marked as read afterwards?
     *
     * @var boolean|null
     */
    public ?bool $readChat = null;
    /**
     * Should the last 10 messages be read afterwards?
     *
     * @var boolean|null
     */
    public ?bool $readMessages = null;
    /**
     * The Id of the message to reply to.
     *
     * @var string|null
     */
    public ?string $replyId = null;
    /**
     * Only for groups, but mentions @number. 
     *
     * @var string|null
     */
    public ?string $mentions = null;
    /**
     * Should the message be marked as "forwarded"?
     *
     * @var boolean|null
     */
    public ?bool $forward = null;
    /**
     * Track the source of the message. Can be useful for CRM and such
     *
     * @var string|null
     */
    public ?string $trackSource = null;
    /**
     * Track the Id of the message. Can be useful for CRM and such.
     *
     * @var string|null
     */
    public ?string $trackId = null;
    /**
     * Should the message be sent async?
     * This message can fail, you should check its status at /message/find and check the field status if its failed or not.
     *
     * @var boolean|null
     */
    public ?bool $async = null;

    public function __construct(
        ?int $delay = null,
        ?bool $readChat = null,
        ?bool $readMessages = null,
        ?string $replyId = null,
        ?string $mentions = null,
        ?bool $forward = null,
        ?string $trackSource = null,
        ?string $trackId = null,
        ?bool $async = null,
    )
    {
        $this->delay = $delay;
        $this->readChat = $readChat;
        $this->readMessages = $readMessages;
        $this->replyId = $replyId;
        $this->mentions = $mentions;
        $this->forward = $forward;
        $this->trackSource = $trackSource;
        $this->trackId = $trackId;
        $this->async = $async;
    }

    public function to(): array
    {
        $content = [
            'delay' => $this->delay,
            'readchat' => $this->readChat,
            'readmessages' => $this->readMessages,
            'replyid' => $this->replyId,
            'mentions' => $this->mentions,
            'forward' => $this->forward,
            'track_source' => $this->trackSource,
            'track_id' => $this->trackId,
            'async' => $this->async
        ];
        $content = array_filter($content, function ($value) {
            return $value !== null;
        });
        return $content;
    }
}