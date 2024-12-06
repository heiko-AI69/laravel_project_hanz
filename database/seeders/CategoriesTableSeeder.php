<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Snacks'],
            ['category_name' => 'Soft Drinks'],
            ['category_name' => 'Noodles'],
        ];

        DB::table('categories')->insert($categories);
    }
}
