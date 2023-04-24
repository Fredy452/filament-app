<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'User Admin',
            'email' => 'correo@admin.com',
            'password' => bcrypt('abcd1234')
        ]);

        \App\Models\User::factory(10)->create();
    }
}
