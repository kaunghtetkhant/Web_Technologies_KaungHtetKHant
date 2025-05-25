<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@gmail.com';
        if(!User::where('email', $email)->first()){
            User::create([
                'email' => $email,
                'password' => bcrypt('shop@1324'),
                'name' => 'Super Admin'
            ]);
        }
    }
}
