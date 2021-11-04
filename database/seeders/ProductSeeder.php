<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;  // ทำหน้าที่ดึงเวลาในปัจจุบันมากับ laravel

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
        DB::table('products')->delete();

        $data = [
            [
                'name' => 'Samsung Galaxy S21',
                'slug' => 'samsung-galary-s21',
                'description' => 'Similique molestias exercitationem officia aut. Itaque doloribus et rerum voluptate iure. Unde veniam magni dignissimos expedita eius',
                'price' => '18500.00',
                'image' => 'https://via.placeholder.com/800x600.png/004466?text=samsung',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            

        ];

        Product::insert($data);

        // ทำการเรียกตัว ProductFactory ที่จะทำการ Faker ข้อมูลให้
        // Product::factory(4999)->create(); // Local สร้าง 4999 ข้อมูล
        Product::factory(999)->create(); // Heroku สร้าง 999 ข้อมูล

    }
}
