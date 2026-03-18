<?php

interface WhatsappDriver
{
    public function token(string $token): static;
    public function receiver(string $identifier): static;
    public function reply(string $replyId): static;

    //Final calls
    public function sendText(string $text, bool $linkPreview = false): string;
}