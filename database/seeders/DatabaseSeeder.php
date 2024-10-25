<?php

namespace Database\Seeders;

use App\Models\Dataset;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Teste 1',
            'email' => 'teste1@email.com',
            'password' => '12345678',
        ]);

        $faker = Faker::create();

        foreach (range(1, 2000) as $index) {
            Dataset::create([
                'code' => strtoupper($faker->lexify('??????')),
                'name' => $faker->name,
                'description' => $faker->paragraph,
                'amount' => $faker->numberBetween(1, 1000)
            ]);
        }
    }
}
