<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'listings_limit' => Plan::LIMITS['starter'],
                'price_eur' => 29.00,
                'sort_order' => 1,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'listings_limit' => Plan::LIMITS['pro'],
                'price_eur' => 79.00,
                'sort_order' => 2,
            ],
            [
                'name' => 'Unlimited',
                'slug' => 'unlimited',
                'listings_limit' => Plan::LIMITS['unlimited'],
                'price_eur' => 149.00,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
