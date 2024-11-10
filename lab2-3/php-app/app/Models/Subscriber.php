<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['name', 'email', 'subscriptions_ids'];

    // Декларируем, что поле subscriptions_ids является массивом JSON
    protected $casts = [
        'subscriptions_ids' => 'array',
    ];

    // Метод для добавления подписки в список ID
    public function addSubscription($subscriptionId)
    {
        $subscriptions = $this->subscriptions_ids ?: []; // Если нет подписок, то создаем пустой массив
        $subscriptions[] = $subscriptionId; // Добавляем новый ID подписки
        $this->subscriptions_ids = $subscriptions; // Сохраняем обновленный список
        $this->save(); // Сохраняем модель
    }
}
