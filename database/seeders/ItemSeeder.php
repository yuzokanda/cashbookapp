<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'content' => '天神にて買い物',
            'amount' => '4400',
            'category' => '衣服費',
            'date' => '2023/08/24'
        ]);

        Item::create([
            'content' => 'スーパーにて買い物',
            'amount' => '1400',
            'category' => '食費',
            'date' => '2023/08/24'
        ]);

        Item::create([
            'content' => '天神までバス往復',
            'amount' => '340',
            'category' => '交通費',
            'date' => '2023/08/24'
        ]);
    }
}
