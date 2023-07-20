<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('primary_categories')->insert([
            [
                'name' => 'トラベルグッズ',
                'sort_order' => 1,
            ],
            [
                'name' => '観光名所',
                'sort_order' => 2,
            ],
            [
                'name' => '旅行保険',
                'sort_order' => 3,
            ]
            ]);

            DB::table('secondary_categories')->insert([
            [
                'name' => 'ザック',
                'sort_order' => 1,
                'primary_category_id' =>1
            ],
            [
                'name' => '礼文島',
                'sort_order' => 2,
                'primary_category_id' =>2
            ],
            [
                'name' => 'HIS',
                'sort_order' => 3,
                'primary_category_id' =>3
            ],
            [
                'name' => 'サングラス',
                'sort_order' => 4,
                'primary_category_id' =>1
            ],
            [
                'name' => '知床',
                'sort_order' => 5,
                'primary_category_id' =>2
            ],
            [
                'name' => '上高地',
                'sort_order' => 6,
                'primary_category_id' =>2
            ]
            ]);
    }
}
