<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $usersData = [
            [
                'name' => "Şerafettin",
                "lastname" => "Sevgili",
                "role" => "etik_kurul",
                'email' => "serafettin.sevgili@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Gözde",
                "lastname" => "Mert",
                "role" => "etik_kurul",
                'email' => "gozde.mert@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Arif",
                "lastname" => "Şener",
                "role" => "etik_kurul",
                'email' => "arif.sener@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Yaprak",
                "lastname" => "Özen",
                "role" => "etik_kurul",
                'email' => "yaprak.ozen@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Kürşat",
                "lastname" => "Yalçıner",
                "role" => "etik_kurul",
                'email' => "kursat.yalciner@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Abdurrahman",
                "lastname" => "Boyacı",
                "role" => "etik_kurul",
                'email' => "abdurrahman.boyaci@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Aynur",
                "lastname" => "Müdüroğlu",
                "role" => "etik_kurul",
                'email' => "aynur.muduroglu@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Esra",
                "role" => "sekreterlik",
                "lastname" => "İleri",
                'email' => "esra.ileri@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Şerafettin",
                "lastname" => "Sevgili",
                "role" => "sekreterlik",
                'email' => "lee@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
            [
                'name' => "Demet",
                "lastname" => "Övelek",
                "role" => "sekreterlik",
                'email' => "demet.ovelek@nisantasi.edu.tr",
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($usersData as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Data seeded successfully.');
    }
}
