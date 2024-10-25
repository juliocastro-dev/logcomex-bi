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
        // Criando uma instancia do Faker
        $faker = Faker::create();

        // Loop para inserir pelo menos 2.000 registros
        foreach (range(1, 2000) as $index) {
            Dataset::create([
                'code' => strtoupper($faker->lexify('??????')), // Gera uma string aleatoria com 6 letras
                'name' => $faker->name, // Gera um nome aleatorio
                'description' => $faker->paragraph, // Gera uma descricao de paragrafo
                'amount' => $faker->numberBetween(1, 1000) // Gera um numero inteiro entre 1 e 1000
            ]);
        }
    }
}
