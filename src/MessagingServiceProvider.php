<?php

namespace Helvetitec\Messaging;

use Illuminate\Support\ServiceProvider;

class MessagingServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->mergeConfigFrom(__DIR__.'/../config/whatsapp.php', 'helvetitec.messaging.whatsapp');
  }

  public function boot()
  {
    if($this->app->runningInConsole()){
      $this->publishes([     
        __DIR__.'/../config/whatsapp.php' => config_path('helvetitec.messaging.whatsapp.php'),
      ], 'helvetitec.messaging.whatsapp.config');      
    }
  }
}
