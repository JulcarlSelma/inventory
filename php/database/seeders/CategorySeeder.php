<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Monitor'],
            ['name' => 'Keyboard'],
            ['name' => 'CCTV'],
            ['name' => 'Mouse'],
            ['name' => 'Cable'],
            ['name' => 'Wire'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
