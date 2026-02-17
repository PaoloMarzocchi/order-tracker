<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerIds = \App\Models\Customer::inRandomOrder()->limit(5)->pluck('id')->toArray();
        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Order::create([
                'customer_id' => fake()->randomElement($customerIds),
                'order_number' => fake()->unique()->numerify('########'),
                'status' => fake()->randomElement(\App\Enums\OrderStatus::seederArray())->value,
                'total_amount' => fake()->randomFloat(2, 100, 1000),
                'order_date' => fake()->dateTimeThisYear()->format('Y-m-d'),
            ]);
        }
    }
}
