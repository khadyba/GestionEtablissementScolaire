<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['nom' => 'Administrateur'],
            ['nom' => 'Professeur'],
            ['nom' => 'Eleves'],
            ['nom' => 'Parent'],
        ]);
    }
}
