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
        \App\Models\Order::insert([
            ['order_number' => 'ORD-1001', 'customer_email' => 'ahmed@test.com', 'status' => 'shipped',   'total' => 750,  'expected_delivery' => now()->addDays(2), 'created_at' => now(), 'updated_at' => now()],
            ['order_number' => 'ORD-1002', 'customer_email' => 'mona@test.com',  'status' => 'pending',   'total' => 1200, 'expected_delivery' => now()->addDays(5), 'created_at' => now(), 'updated_at' => now()],
            ['order_number' => 'ORD-1003', 'customer_email' => 'ahmed@test.com', 'status' => 'cancelled', 'total' => 300,  'expected_delivery' => null,             'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
