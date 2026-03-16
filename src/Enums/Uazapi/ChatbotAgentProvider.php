<?php

namespace Helvetitec\Messaging\Enums\Uazapi;

enum ChatbotAgentProvider: string
{
    case OPENAI = 'openai';
    case ANTHROPIC = 'anthropic';
    case GEMINI = 'gemini';
    case DEEPSEEK = 'deepseek';
}