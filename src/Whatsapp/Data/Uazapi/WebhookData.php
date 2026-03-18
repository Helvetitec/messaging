<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

final class WebhookData
{
    public readonly int $id;
    public readonly bool $enabled;
    public readonly string $url;
    public readonly array $events;
    public readonly array $excludeMessages;
    public readonly bool $addUrlEvents;
    public readonly bool $addUrlTypesMessages;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->enabled = $data['enabled'];
        $this->url = $data['url'];
        $this->events = $data['events'];
        $this->excludeMessages = $data['excludeMessages'];
        $this->addUrlEvents = $data['addUrlEvents'];
        $this->addUrlTypesMessages = $data['addUrlTypesMessages'];
    }
}