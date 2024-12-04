<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscriber;
use App\Models\Subscription;

class SubscriberSeeder extends Seeder
{
    public function run()
    {
        // Получаем полные объекты подписок
        $subscriptions1 = Subscription::whereIn('id', [1, 2])->get()->toArray();
        $subscriptions2 = Subscription::where('id', 2)->get()->toArray();

        // Создаем подписчиков с полными объектами подписок в поле `subscriptions`
        Subscriber::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'subscriptions' => $subscriptions1,
            ]
        );

        Subscriber::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'subscriptions' => $subscriptions2,
            ]
        );
    }
}
