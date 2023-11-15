<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=collect([
            [
                'name'=>'Athiqul Hasan Momin',
                'username'=>'athiq007',
                'email'=>'athiqulhasan.4@gmail.com',
                'password'=>Hash::make('password'),
                'mobile'=>'01632241032',
                'role'=>'admin',
            ],

            [
                'name'=>'Momin Hasan',
                'username'=>'momin007',
                'email'=>'momin.hasan4@gmail.com',
                'password'=>Hash::make('password'),
                'mobile'=>'01632241031',
                'role'=>'vendor',
            ],
            [
                'name'=>'Hasan Evathiq',
                'username'=>'hasan007',
                'email'=>'momingpay@gmail.com',
                'password'=>Hash::make('password'),
                'mobile'=>'01632241033',
                'role'=>'user',
            ],

        ]);

        $users->each(function ($item){
           User::create($item);
        });
    }
}
