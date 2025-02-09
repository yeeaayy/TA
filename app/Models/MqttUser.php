<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MqttUser extends Model
{
    use HasFactory;

    protected $table = 'mqtt_users';

    protected $fillable = [
        'mqtt_id',
        'password',
        'topic',
        'user_id',  // Tambahkan user_id di sini
    ];
}


