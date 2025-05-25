<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list  = ['May Thu Aung', 'Naing Min Khant', 'Khant Si Thu'];

        $default_password = 'password';
        foreach ($list as $item){
            Customer::create([
                'name' => $item,
                'username' => strtolower(str_replace(' ','',$item)).'@myansis.com',
                'password' => bcrypt($default_password)
            ]);
        }

    }
}
