<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminData = [
            'first_name' => "Root",
            'last_name' => "User",
            'email' => "admin@laravel.com",
            'password' => Hash::make('admin1234'),
            'admin' => true
        ];
        $admin = new User($adminData);
        $admin->save();
    }
}
