<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'petugas@sarpras.sch.id'],
            [
                'name'     => 'Budi Teknisi Sarpras',
                'password' => Hash::make('password123'),
                'role'     => 'petugas',
            ]
        );
    }
}