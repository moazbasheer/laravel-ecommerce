<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 5; $i++) {
            Product::create([
                'name' => 'Laptop ' . $i,
                'slug' => 'laptop-' . $i,
                'details' => '15 inch, 500GB SSD, 8GB RAM',
                'price' => '12999',
                'description' => 'Lorem ipsum'
            ])->categories()->attach(1);
        }

        for($i = 1; $i <= 5; $i++) {
            Product::create([
                'name' => 'Desktop ' . $i,
                'slug' => 'desktop-' . $i,
                'details' => '15 inch, 500GB SSD, 8GB RAM',
                'price' => '12999',
                'description' => 'Lorem ipsum'
            ])->categories()->attach(2);
        }

        for($i = 1; $i <= 5; $i++) {
            Product::create([
                'name' => 'Phone ' . $i,
                'slug' => 'phone-' . $i,
                'details' => '15 inch, 500GB SSD, 8GB RAM',
                'price' => '12999',
                'description' => 'Lorem ipsum'
            ])->categories()->attach(3);
        }

        for($i = 1; $i <= 5; $i++) {
            Product::create([
                'name' => 'Tablet ' . $i,
                'slug' => 'tablet-' . $i,
                'details' => '15 inch, 500GB SSD, 8GB RAM',
                'price' => '12999',
                'description' => 'Lorem ipsum'
            ])->categories()->attach(4);
        }
    }
}
