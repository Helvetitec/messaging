<?php

namespace Helvetitec\Messaging\Enums;

enum WhatsappMessageType: string
{
    case CONVERSATION = 'conversation';
    case EXTENDED_TEXT_MESSAGE = 'extendedTextMessage';

    case IMAGE_MESSAGE = 'imageMessage';
    case VIDEO_MESSAGE = 'videoMessage';
    case AUDIO_MESSAGE = 'audioMessage';
    case DOCUMENT_MESSAGE = 'documentMessage';
    case DOCUMENT_WITH_CAPTION_MESSAGE = 'documentWithCaptionMessage';

    case STICKER_MESSAGE = 'stickerMessage';
    case STICKER_PACK_MESSAGE = 'stickerPackMessage';

    case CONTACT_MESSAGE = 'contactMessage';
    case CONTACTS_ARRAY_MESSAGE = 'contactsArrayMessage';

    case LOCATION_MESSAGE = 'locationMessage';
    case LIVE_LOCATION_MESSAGE = 'liveLocationMessage';

    case POLL_CREATION_MESSAGE = 'pollCreationMessage';
    case POLL_UPDATE_MESSAGE = 'pollUpdateMessage';
    case POLL_RESULT_SNAPSHOT_MESSAGE = 'pollResultSnapshotMessage';

    case REACTION_MESSAGE = 'reactionMessage';
    case ENC_REACTION_MESSAGE = 'encReactionMessage';

    case LIST_MESSAGE = 'listMessage';
    case LIST_RESPONSE_MESSAGE = 'listResponseMessage';

    case BUTTONS_MESSAGE = 'buttonsMessage';
    case BUTTONS_RESPONSE_MESSAGE = 'buttonsResponseMessage';

    case TEMPLATE_MESSAGE = 'templateMessage';
    case TEMPLATE_BUTTON_REPLY_MESSAGE = 'templateButtonReplyMessage';

    case INTERACTIVE_MESSAGE = 'interactiveMessage';
    case INTERACTIVE_RESPONSE_MESSAGE = 'interactiveResponseMessage';

    case GROUP_INVITE_MESSAGE = 'groupInviteMessage';
    case GROUP_MENTIONED_MESSAGE = 'groupMentionedMessage';

    case PROTOCOL_MESSAGE = 'protocolMessage';

    case EPHEMERAL_MESSAGE = 'ephemeralMessage';

    case VIEW_ONCE_MESSAGE = 'viewOnceMessage';
    case VIEW_ONCE_MESSAGE_V2 = 'viewOnceMessageV2';
    case VIEW_ONCE_MESSAGE_V2_EXTENSION = 'viewOnceMessageV2Extension';

    case DEVICE_SENT_MESSAGE = 'deviceSentMessage';

    case SENDER_KEY_DISTRIBUTION_MESSAGE = 'senderKeyDistributionMessage';

    case PRODUCT_MESSAGE = 'productMessage';
    case ORDER_MESSAGE = 'orderMessage';
    case INVOICE_MESSAGE = 'invoiceMessage';

    case REQUEST_PAYMENT_MESSAGE = 'requestPaymentMessage';
    case SEND_PAYMENT_MESSAGE = 'sendPaymentMessage';
    case DECLINE_PAYMENT_REQUEST_MESSAGE = 'declinePaymentRequestMessage';
    case CANCEL_PAYMENT_REQUEST_MESSAGE = 'cancelPaymentRequestMessage';

    case CALL = 'call';
    case CALL_LOG_MESSAGE = 'callLogMesssage';

    case EVENT_MESSAGE = 'eventMessage';
    case EVENT_RESPONSE_MESSAGE = 'eventResponseMessage';

    case NEWSLETTER_ADMIN_INVITE_MESSAGE = 'newsletterAdminInviteMessage';

    case STATUS_NOTIFICATION_MESSAGE = 'statusNotificationMessage';
    case STATUS_QUOTED_MESSAGE = 'statusQuotedMessage';
    case STATUS_STICKER_INTERACTION_MESSAGE = 'statusStickerInteractionMessage';

    case ALBUM_MESSAGE = 'albumMessage';

    case KEEP_IN_CHAT_MESSAGE = 'keepInChatMessage';
    case PIN_IN_CHAT_MESSAGE = 'pinInChatMessage';

    case COMMENT_MESSAGE = 'commentMessage';
    case ENC_COMMENT_MESSAGE = 'encCommentMessage';

    case EDITED_MESSAGE = 'editedMessage';

    case BOT_INVOKE_MESSAGE = 'botInvokeMessage';
    case BOT_TASK_MESSAGE = 'botTaskMessage';
    case BOT_FORWARDED_MESSAGE = 'botForwardedMessage';

    case QUESTION_RESPONSE_MESSAGE = 'questionResponseMessage';

    case REQUEST_PHONE_NUMBER_MESSAGE = 'requestPhoneNumberMessage';

    case MESSAGE_HISTORY_BUNDLE = 'messageHistoryBundle';
    case MESSAGE_HISTORY_NOTICE = 'messageHistoryNotice';

    case PLACEHOLDER_MESSAGE = 'placeholderMessage';

    case SECRET_ENCRYPTED_MESSAGE = 'secretEncryptedMessage';
}
