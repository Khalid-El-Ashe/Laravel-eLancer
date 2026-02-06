<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log as FacadesLog;

class Log
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toLog($notifiable);
        FacadesLog::info("[$notifiable->name]: $message ");
    }
}
