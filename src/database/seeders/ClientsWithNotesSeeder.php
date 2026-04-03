<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Note;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientsWithNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::factory(10)
            ->has(Note::factory(3))
            ->create();
    }
}
