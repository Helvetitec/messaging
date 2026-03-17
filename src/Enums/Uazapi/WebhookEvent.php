<?php

namespace Helvetitec\Messaging\Enums\Uazapi;

enum WebhookEvent: string
{
    /**
     * Alterações no estado da conexão
     */
    case CONNECTION = 'connection';
    /**
     * Recebimento de histórico de mensagens
     */
    case HISTORY = 'history';
    /**
     * Novas mensagens recebidas
     */
    case MESSAGES = 'messages';
    /**
     * Atualizações em mensagens existentes
     */
    case MESSAGES_UPDATE = 'messages_update';
    /**
     * Eventos de chamadas VoIP
     */
    case CALL = 'call';
    /**
     * Atualizações na agenda de contatos
     */
    case CONTACTS = 'contacts';
    /**
     * Alterações no status de presença
     */
    case PRESENCE = 'presence';
    /**
     * Modificações em grupos
     */
    case GROUPS = 'groups';
    /**
     * Gerenciamento de etiquetas
     */
    case LABELS = 'labels';
    /**
     * Eventos de conversas
     */
    case CHATS = 'chats';
    /**
     * Alterações em etiquetas de conversas
     */
    case CHAT_LABELS = 'chat_labels';
    /**
     * Bloqueios/desbloqueios
     */
    case BLOCKS = 'blocks';
    /**
     * Atualizações de leads
     */
    case LEADS = 'leads';
    /**
     * Atualizações de campanhas, quando inicia, e quando completa
     */
    case SENDER = 'sender';
}