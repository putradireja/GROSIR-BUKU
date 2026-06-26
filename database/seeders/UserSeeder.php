<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Kasir Utama',
            'email' => 'kasir@grosirbuku.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir'
        ]);
    }
}