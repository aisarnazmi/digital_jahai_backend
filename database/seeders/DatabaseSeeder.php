<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name'      => 'Super Admin',
            'email'     => 'digital.jahai@gmail.com',
            'password'  => bcrypt('D!g!talJaha!')
        ]);
    }
}
