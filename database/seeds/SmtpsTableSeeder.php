<?php

use App\Smtp;
use Illuminate\Database\Seeder;

class SmtpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Je fais un truncate de la table avant de la peupler
        Smtp::truncate();

        Smtp::create([
            'host' => 'mail.infomaniak.com',
            'port' => '587',
            'mailhost' => 'sms@hyperaccesss.com',
            'password' => '123456sms',
            'sender' => 'Ressources Applicatif HAS',
            'server_name' => 'Ressources Applicatif HAS',
            ]);
    }
}
