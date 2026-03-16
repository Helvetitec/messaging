<?php

use Helvetitec\Messaging\Whatsapp\Uazapi\UazapiWebhook;
use Illuminate\Support\Facades\Route;

Route::any(
    config('helvetitec.messaging.whatsapp.uazapi.global_webhoook', 'uazapi'), 
    [UazapiWebhook::class, 'process']
);