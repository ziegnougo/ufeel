<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@ufeel.ci'],
            [
                'name'     => 'Super Admin UFEEL',
                'password' => Hash::make('ufeel2026admin'),
                'role'     => 'superadmin',
            ]
        );
    }
}
