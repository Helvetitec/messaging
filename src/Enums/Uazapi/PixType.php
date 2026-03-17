<?php

namespace Helvetitec\Messaging\Enums\Uazapi;

enum PixType: string
{
    case CPF = 'CPF';
    case CNPJ = 'CNPJ';
    case PHONE = 'PHONE';
    case EMAIL = 'EMAIL';
    case EVP = 'EVP';
}