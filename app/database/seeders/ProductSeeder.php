<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'title' => 'Produto 1',
            'price_sale' => 100.00,
            'price_cost' => 50.00,
            'active' => true,
            'description' => 'Descrição do Produto 1',
            'image' => 'produto1.jpg',
        ]);

        Product::create([
            'title' => 'Produto 2',
            'price_sale' => 150.00,
            'price_cost' => 90.00,
            'active' => true,
            'description' => 'Descrição do Produto 2',
            'image' => 'produto2.jpg',
        ]);

        Product::create([
            'title' => 'Produto 3',
            'price_sale' => 200.00,
            'price_cost' => 120.00,
            'active' => false,
            'description' => 'Descrição do Produto 3',
            'image' => 'produto3.jpg',
        ]);
    }
}
