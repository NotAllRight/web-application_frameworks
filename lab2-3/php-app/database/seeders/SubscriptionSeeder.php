<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\Subscriber;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        // Создаем подписки
        $subscription1 = Subscription::firstOrCreate([
            'id' => 1,
        ], [
            'service' => 'Premium News Service',
            'topic' => 'Technology',
            'payload' => json_encode(['key' => 'value']),
            'expired_at' => now()->addMonth(),
        ]);

        $subscription2 = Subscription::firstOrCreate([
            'id' => 2,
        ], [
            'service' => 'Sports News Service',
            'topic' => 'Football',
            'payload' => json_encode(['key' => 'value']),
            'expired_at' => now()->addMonth(),
        ]);

        // Присваиваем подписки существующим подписчикам
        $subscriber1 = Subscriber::find(1);
        $subscriber2 = Subscriber::find(2);

        if ($subscriber1) {
            $subscriber1->update([
                'subscriptions_ids' => json_encode([$subscription1->id, $subscription2->id]),
            ]);
        }

        if ($subscriber2) {
            $subscriber2->update([
                'subscriptions_ids' => json_encode([$subscription2->id]),
            ]);
        }
    }
}


