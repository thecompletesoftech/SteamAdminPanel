<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =  [
            'username' => 'Admin',
            'name' => 'Anil',
            'email' => 'steamhouse@gmail.com',
            'phone' => '7984954227',
            'about' => 'Demo',
            'c_password' => Hash::make('12345678'),
            'password' => Hash::make('12345678'),
            'role'=>'3',
        ];
        User::create($data);
    }
}
