<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

use Illuminate\Support\Collection;

class LoadMessagesResponse
{
    public Collection $messages;
    public int $returnedMessages;
    public int $limit;
    public int $offset;
    public int $nextOffset;
    public bool $hasMore;
    
    public function __construct(
        Collection $messages,
        int $returnedMessages,
        int $limit,
        int $offset,
        int $nextOffset,
        bool $hasMore
    )
    {
        $this->messages = $messages;
        $this->returnedMessages = $returnedMessages;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->nextOffset = $nextOffset;
        $this->hasMore = $hasMore;
    }
}