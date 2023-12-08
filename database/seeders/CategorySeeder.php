<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => '食料品',
            'user_id' => 0,
        ]);

        Category::create([
            'name' => '交通',
            'user_id' => 0,
        ]);

        Category::create([
            'name' => '衣料品',
            'user_id' => 0,
        ]);

        Category::create([
            'name' => '通信',
            'user_id' => 0,
        ]);

        Category::create([
            'name' => '光熱',
            'user_id' => 0,
        ]);

        Category::create([
            'name' => 'レジャー',
            'user_id' => 0,
        ]);

        Category::create([
            'name' => '雑費',
            'user_id' => 0,
        ]);
    }
}
