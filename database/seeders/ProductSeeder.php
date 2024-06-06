<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'free',
            'price' => 0,
            'rate_limit' => 10,
        ]);

        Product::create([
            'name' => 'premium',
            'price' => 19.99,
            'rate_limit' => 99,
        ]);
    }
}
