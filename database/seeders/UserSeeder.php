<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = new User();
    	$user->first_name = 'Admin';
    	$user->last_name = 'User';
    	$user->role = 'admin';
    	$user->email = 'admin.user@product-bro.com';
    	$user->password = Hash::make('password123');
        $user->save();
    }
}