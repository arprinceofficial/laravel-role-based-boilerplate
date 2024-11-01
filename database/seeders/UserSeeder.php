<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        ]);
    }
}
