<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Je fais un truncate de la table avant de la peupler
        User::truncate();

        User::create([
            'name' => 'Super Administrateur',
            'username' => 'superadministrateur',
            'password' => Hash::make('superadministrateur'),
            'creer_par' => '',
            'role_id' => 1,
        ]);

        User::create([
            'name' => 'Administrateur',
            'username' => 'administrateur',
            'password' => Hash::make('admin'),
            'creer_par' => 'superadministrateur',
            'role_id' => 2,
        ]);
    }
}
