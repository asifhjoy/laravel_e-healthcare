<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=3;$i++)
            {
                DB::table('users')->insert([
                    'name' => 'Admin 0'.$i,
                    'gender' => 'Male',
                    'bday' => '1997-1-1',
                    'email' => 'admin'.$i.'@gmail.com',
                    'phone' => '+88018'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                    'utype' => 'Admin',
                    'password' => Hash::make('00000000'),
                    'email_verified_at' => Carbon::now()->addMinutes(2),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ]);
            }
        for($i=1;$i<=5;$i++)
        {
            DB::table('users')->insert([
                'name' => 'Doctor 0'.$i,
                'gender' => 'Male',
                'bday' => '1995-1-1',
                'email' => 'doctor'.$i.'@gmail.com',
                'phone' => '+88017'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                'utype' => 'Doctor',
                'password' => Hash::make('00000000'),
                'email_verified_at' => Carbon::now()->addMinutes(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);
        }
        for($i=1;$i<=5;$i++)
        {
            DB::table('users')->insert([
                'name' => 'Client 0'.$i,
                'gender' => 'Female',
                'bday' => '2000-1-1',
                'email' => 'client'.$i.'@gmail.com',
                'phone' => '+88019'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                'utype' => 'Client',
                'password' => Hash::make('00000000'),
                'email_verified_at' => Carbon::now()->addMinutes(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);
        }

    }
}
