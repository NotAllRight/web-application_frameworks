<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use OpenApi\Annotations as OA;

// /**
//  * @OA\Schema(
//  *     schema="Subscription",
//  *     type="object",
//  *     properties={
//  *         @OA\Property(property="id", type="integer", example=1),
//  *         @OA\Property(property="name", type="string", example="Premium"),
//  *         @OA\Property(property="price", type="integer", example=9)
//  *     }
//  * )
//  */
// class Subscription extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'service',
//         'topic',
//         'payload',
//         'expired_at',
//     ];
//     protected $hidden = ['created_at', 'updated_at'];
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Subscription",
 *     type="object",
 *     required={"service", "topic", "payload", "expired_at"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="service", type="string", example="Premium"),
 *     @OA\Property(property="topic", type="string", example="Sports"),
 *     @OA\Property(property="payload", type="json", example="{'key': 'value'}"),
 *     @OA\Property(property="expired_at", type="string", format="date-time", example="2025-01-03 16:20:13")
 * )
 */
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

    /**
     * Динамически генерируем описание для Swagger (если нужно).
     * Можно сделать дополнительные проверки на поле в базе данных.
     */
    public static function getSwaggerProperties()
    {
        $properties = [];
        $columns = (new static)->getFillable();  // Получаем все заполняемые поля

        foreach ($columns as $column) {
            // Для каждого поля добавляем свойство
            $properties[] = new OA\Property(
                property: $column,
                type: 'string', // Пример типа данных, можно сделать более гибким
                example: "example_value" // Пример, можно подставить значения из базы или использовать дефолтные
            );
        }

        return $properties;
    }
}
