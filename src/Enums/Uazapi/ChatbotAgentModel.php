<?php

namespace Helvetitec\Messaging\Enums\Uazapi;

enum ChatbotAgentModel: string
{
    case OPENAI_4o = 'gpt-4o';
    case OPENAI_4o_MINI = 'gpt-4o-mini';
    case OPENAI_3_5_TURBO = 'gpt-3.5-turbo';
    case ANTHROPIC_3_5_SONNET_LATEST = 'claude-3-5-sonnet-latest';
    case ANTHROPIC_3_5_HAIKU_LATEST = 'claude-3-5-haiku-latest';
    case ANTHROPIC_3_OPUS_LATEST = 'claude-3-opus-latest';
    case GEMINI_2_0_FLASH_EXP = 'gemini-2.0-flash-exp';
    case GEMINI_1_5_PRO = 'gemini-1.5-pro';
    case GEMINI_1_5_FLASH = 'gemini-1.5-flash';
    case DEEPSEEK_CHAT = 'deepseek-chat';
    case DEEPSEEK_REASONER = 'deepseek-reasoner';
}