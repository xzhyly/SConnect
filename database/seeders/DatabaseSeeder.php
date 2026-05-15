<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::updateOrCreate(['email' => 'admin@scholarconnect.test'], [
            'name'                 => 'Admin User',
            'password'             => Hash::make('password'),
            'is_admin'             => true,
            'email_notifications'  => false,
            'municipality'         => null,
            'course'               => null,
            'gwa'                  => null,
            'year_level'           => null,
        ]);

        // Student 1 — qualifies for most scholarships
        User::updateOrCreate(['email' => 'juan@scholarconnect.test'], [
            'name'                => 'Juan dela Cruz',
            'password'            => Hash::make('password'),
            'is_admin'            => false,
            'email_notifications' => true,
            'municipality'        => 'Daet',
            'course'              => 'BSIT',
            'gwa'                 => 1.50,
            'year_level'          => 2,
        ]);

        // Student 2 — average student
        User::updateOrCreate(['email' => 'maria@scholarconnect.test'], [
            'name'                => 'Maria Santos',
            'password'            => Hash::make('password'),
            'is_admin'            => false,
            'email_notifications' => true,
            'municipality'        => 'Labo',
            'course'              => 'BSED',
            'gwa'                 => 2.25,
            'year_level'          => 3,
        ]);

        // Student 3 — qualifies for LGU scholarships
        User::updateOrCreate(['email' => 'pedro@scholarconnect.test'], [
            'name'                => 'Pedro Reyes',
            'password'            => Hash::make('password'),
            'is_admin'            => false,
            'email_notifications' => true,
            'municipality'        => 'Talisay',
            'course'              => 'BSIT',
            'gwa'                 => 2.00,
            'year_level'          => 1,
        ]);
    }
}