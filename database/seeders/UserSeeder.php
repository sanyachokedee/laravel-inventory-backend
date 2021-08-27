<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ลบข้อมูลเก่าออกไปก่อน
        DB::table('users')->delete();

        $data = [
            'fullname' => 'Samit Koyom',
            'username' => 'iamsamit',
            'email' => 'samit@email.com',
            'password' => Hash::make('123456'),
            'tel' => '098-895-5555',
            'avatar' => 'https://via.placeholder.com/400x400.png/004466?text=animals+omnis',
            'role' => '1',
            'remember_token' => 'asdfghjklp'
        ];

        User::create($data);

        // ทำการเรียกตัว UserFactory ทำตัว Faker ให้เรา
        User::factory(99)->create();  // (จำนวนที่ต้องการ 99)

    }
}
