<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Azizbek_08',
            'email' => 'webcoderazizbek@gmail.com',
            'password' => Hash::make('Azizbek987'),
            'role' => 'admin',
        ]);
   
    }
}
