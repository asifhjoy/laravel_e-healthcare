<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'dptcode' => 'general',
                'dptname' => 'General Health',
            ],

            [
                'dptcode' => 'tooth',
                'dptname' => 'Dentistry',
            ],
            [
                'dptcode' => 'heart',
                'dptname' => 'Cardiology',
            ],
            [
                'dptcode' => 'gastric',
                'dptname' => 'Gastroenterology',
            ],
            [
                'dptcode' => 'ent',
                'dptname' => 'Ear, Nose and Throat',
            ],
            [
                'dptcode' => 'gyne',
                'dptname' => 'Gynecology',
            ],
            [
                'dptcode' => 'blood',
                'dptname' => 'Hematology',
            ],
            [
                'dptcode' => 'brain',
                'dptname' => 'Neurology',
            ],
            [
                'dptcode' => 'nutrition',
                'dptname' => 'Nutrition and Diet',
            ],
            [
                'dptcode' => 'cancer',
                'dptname' => 'Oncology / Cancer',
            ],
            [
                'dptcode' => 'eye',
                'dptname' => 'Ophthalmology / Eye',
            ],
            [
                'dptcode' => 'physio',
                'dptname' => 'Physiotherapy',
            ],
            [
                'dptcode' => 'kidney',
                'dptname' => 'Nephrology / Kidney',
            ],
            [
                'dptcode' => 'bone',
                'dptname' => 'Orthopedics / Bone',
            ],

            [
                'dptcode' => 'psy',
                'dptname' => 'Psychology',
            ],

        ]);

    }
}
