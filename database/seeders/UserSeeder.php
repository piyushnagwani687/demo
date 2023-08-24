<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $user = new User();
        $user->name = 'Alex White';
        $user->email = 'alex@example.com';
        $user->password = Hash::make(123456);
        $user->role = 'admin';
        $user->save();
    }

}
