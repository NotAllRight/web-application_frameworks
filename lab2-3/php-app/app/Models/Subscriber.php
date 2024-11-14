<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['name', 'email', 'subscriptions'];
    protected $hidden = ['created_at', 'updated_at'];

    // Декларируем, что поле subscriptions является массивом JSON
    protected $casts = [
        'subscriptions' => 'array',  // Кастим поле subscriptions в массив
    ];

    // Метод для загрузки подписок с полной информацией
    public function getFullSubscriptionsAttribute()
    {
        // Получаем все подписки по ID, которые хранятся в поле subscriptions
        return Subscription::whereIn('id', $this->subscriptions ?? [])->get();
    }
}
