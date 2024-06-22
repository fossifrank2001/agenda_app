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
        $user = new User();
        $user->name = 'FASSEU Steve';
        $user->email = 's.fasseu@gmail.com';
        $user->password = 'Agenda@2024';
        $user->role = User::ADMIN;
        $user->save();
    }
}
