<?php

use Helvetitec\Messaging\Enums\StoryMediaType;
use Helvetitec\Messaging\Enums\WhatsappPresence;

interface WhatsappHandler
{
    public function server(string $server): static;
    public function token(string $token): static;
    public function receiver(string $identifier): static;
    public function reply(string $replyId): static;

    #region Messages To Send
    public function sendText(string $text, bool $linkPreview = false): string;
    public function sendImage(string $file, string $caption): string;
    public function sendVideo(string $file, string $caption): string;
    public function sendAudio(string $file): string;
    public function sendMyAudio(string $file): string;
    public function sendPtt(string $file): string;
    public function sendPtv(string $file): string;
    public function sendSticker(string $file): string;
    public function sendDocument(string $file, string $docName, string $caption): string;
    public function sendVCard(string $fullName, string $phoneNumber, string $organization, string $email, string $url): string;
    public function sendLocation(float $latitude, float $longitude, ?string $name, ?string $address, ): string;
    public function updatePresence(WhatsappPresence $presence, int $durationInMs): bool;
    public function sendStory(StoryMediaType $type, int $backgroundColor, int $font, ?string $text, ?string $file): string;
    #endregion
}