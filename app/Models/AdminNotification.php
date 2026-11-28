<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    public static function record(string $type, string $message): void
    {
        $notification = new self;
        $notification->event_type = $type;
        $notification->message = $message;
        $notification->save();
    }
}
