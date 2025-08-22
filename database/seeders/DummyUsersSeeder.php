<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create additional artists
        User::factory()
            ->count(8)
            ->artist()
            ->create();

        // Create additional clients
        User::factory()
            ->count(5)
            ->create([ 'role' => 'client' ]);

        $this->command?->info('Dummy users created: 8 artists, 5 clients.');
    }
}
