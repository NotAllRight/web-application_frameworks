<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Subscriber",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *         @OA\Property(
 *             property="subscriptions", 
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="topic", type="string", example="Technology"),
 *                     @OA\Property(property="payload", type="string", example="{'key': 'value'}",),
 *                     @OA\Property(property="service", type="string", example="Premium News Service"),
 *                     @OA\Property(property="expired_at", type="string", format="date-time", example="2025-01-03T16:20:13Z")
 *                 }
 *             ),
 *         ),
 *     }
 * )
 */
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
