<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscriber;

class SubscriberSeeder extends Seeder
{
    public function run()
    {
        // Создаем подписчиков, если они еще не существуют
        Subscriber::firstOrCreate([
            'id' => 1,
        ], [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        Subscriber::firstOrCreate([
            'id' => 2,
        ], [
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
        ]);
    }
}

