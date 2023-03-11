<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        Category::insert([
            ['name' => 'Laptops', 'slug' => 'laptops', 'created_at' => $now],
            ['name' => 'Desktops', 'slug' => 'desktops', 'created_at' => $now],
            ['name' => 'Mobile Phones', 'slug' => 'mobile-phones', 'created_at' => $now],
            ['name' => 'Tablets', 'slug' => 'tablets', 'created_at' => $now],
            ['name' => 'TVs', 'slug' => 'tvs', 'created_at' => $now],
            ['name' => 'Digital Cameras', 'slug' => 'digital-cameras', 'created_at' => $now],
            ['name' => 'Appliances', 'slug' => 'appliances', 'created_at' => $now],

        ]);
    }
}
