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

    // Связь многие ко многим с подписчиками
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscription_subscriber');
    }
}
