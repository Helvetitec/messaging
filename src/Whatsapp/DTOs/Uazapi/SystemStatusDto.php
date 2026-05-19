<?php

namespace Helvetitec\Messaging\Whatsapp\DTOs\Uazapi;

use Illuminate\Support\Carbon;

class SystemStatusDto
{
    public function __construct(
        public bool $ok,
        public string $info,
        public string $dc,
        public Carbon $lastCheck,
        public string $serverStatus,
        public int $totalInstances
    )
    {
    }
}