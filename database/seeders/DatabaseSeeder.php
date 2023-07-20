<?php

namespace Database\Seeders;
use App\Models\Product;
use App\Models\Stock;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            OwnerSeeder::class,
        // 外部キー制約の関係上、productを生成する場合は shop image category を事前に作成した上でproductseeder(product stock)を読み込む必要がある
            ShopSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class,
            // ProductSeeder::class,
            // StockSeeder::class
            UserSeeder::class
        ]);
        Product::factory(100)->create();
        Stock::factory(100)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
