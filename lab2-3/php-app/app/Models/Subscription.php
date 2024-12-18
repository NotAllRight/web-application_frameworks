<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'service',
        'topic',
        'payload',
        'expired_at',
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
