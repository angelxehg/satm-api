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
            'name' => "Root User",
            'email' => "admin@cimat.mx",
            'password' => Hash::make('admin1234'),
        ];
        $admin = new User($adminData);
        $admin->save();
    }
}
