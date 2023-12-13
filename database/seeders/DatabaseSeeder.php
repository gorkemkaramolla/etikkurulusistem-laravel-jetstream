<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => "Şerafettin",
            "lastname" => "Sevgili",
            "role" => "etik_kurul",
            'email' => "serafettin.sevgili@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "Sibel",
            "role" => "etik_kurul",

            "lastname" => "Boran",
            'email' => "sibel.boran@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "etikkurul3",
            "role" => "etik_kurul",

            "lastname" => "etikkurul3",
            'email' => "etikkurul3@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "etikkurul4",
            "lastname" => "etikkurul4",
            "role" => "etik_kurul",
            'email' => "etikkurul4@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "etikkurul5",
            "lastname" => "etikkurul5",
            "role" => "etik_kurul",
            'email' => "etikkurul5@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "sekreter1",
            "lastname" => "nişantaşı",
            'email' => "sekreter1@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "sekreter2",
            "lastname" => "nişantaşı",
            'email' => "sekreter2@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
    }
}
