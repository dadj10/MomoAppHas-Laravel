<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Je fais un truncate de la table avant de la peupler
        Role::truncate();

        Role::create(['name' => 'superadministrateur']);
        Role::create(['name' => 'administrateur']);
        Role::create(['name' => 'utilisateur']);
    }
}
