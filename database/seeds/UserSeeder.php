<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Companies;
use App\Employees;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = [
        [
            'name' => 'Admin',
            'email' => '​admin@grtech.com.my',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ],
        [
            'name' => 'User1',
            'email' => 'user@grtech.com.my',
            'password' => bcrypt('password'),
            'role' => 'employee'
        ],
        ];
        User::insert($users);
    }
}
