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
            'name' => "Gözde",
            "lastname" => "Mert",
            "role" => "etik_kurul",

            'email' => "gozde.mert@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "Arif",
            "lastname" => "Şener",
            "role" => "etik_kurul",

            'email' => "arif.sener@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "Yaprak",
            "lastname" => "Özen",
            "role" => "etik_kurul",
            'email' => "yaprak.ozen@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "Kürşat",
            "lastname" => "Yalçıner",
            "role" => "etik_kurul",
            'email' => "kursat.yalciner@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "Abdurrahman",
            "lastname" => "Boyacı",
            "role" => "etik_kurul",
            'email' => "abdurrahman.boyaci@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "Aynur",
            "lastname" => "Müdüroğlu",
            "role" => "etik_kurul",
            'email' => "aynur.muduroglu@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "Esra",
            "role" => "sekreterlik",
            "lastname" => "İleri",
            'email' => "esra.ileri@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
        DB::table('users')->insert([
            'name' => "Şerafettin",
            "lastname" => "Sevgili",
            "role" => "sekreterlik",
            'email' => "serafettin.sevgili2@nisantasi.edu.tr",
            'password' => Hash::make('password'),

        ]);
    }
}
