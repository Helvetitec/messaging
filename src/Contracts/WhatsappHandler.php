<?php

namespace Helvetitec\Messaging\Contracts;

use Helvetitec\Messaging\Enums\StoryMediaType;
use Helvetitec\Messaging\Enums\WhatsappPresence;
use Helvetitec\Messaging\Whatsapp\DTOs\Uazapi\SystemStatusDto;
use Illuminate\Support\Collection;

interface WhatsappHandler
{
    public function server(string $server): static;
    public function token(string $token): static;
    public function receiver(string $identifier): static;
    public function reply(string $replyId): static;

    #region Instances
    // public function createInstance(): void;
    // public function connectInstance(): void;
    // public function disconnectInstance(): void;
    // public function deleteInstance(): void;
    #endregion

    #region Messages
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

    // public function downloadAttachment(string $messageId);
    // public function loadMessagesFromChat(string $chatId, int $limit, int $offset);
    // public function markRead(array $messageIds);
    // public function sendReaction(string $number, string $reaction, string $messageId);
    // public function editMessage(string $messageId, string $text);
    // public function deleteMessage(string $messageId);
    #endregion

    #region Contacts
    public function verifyNumbers(array $numbers): Collection;
    #endregion

    #region Admin
    public function systemStatus(): SystemStatusDto;
    #endregion
}