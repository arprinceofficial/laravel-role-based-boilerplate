<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'ashiqurr04@gmail.com',
            'first_name' => 'Md. Ashiqur',
            'last_name' => 'Rahman',
            'mobile_number' => '01677879681',
            'password' => bcrypt('12345678'),
            'status' => 1,
            'role_id' => 2,
        ]);

        // DB::table('users')->insert([
        //     'first_name' => 'Md. Ashiqur',
        //     'last_name' => 'Rahman',
        //     'email' => 'ashiqurr04@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => bcrypt('your_password'),
        //     'remember_token' => Str::random(10),
        //     'mobile_number' => '01677879681',
        //     'status' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
