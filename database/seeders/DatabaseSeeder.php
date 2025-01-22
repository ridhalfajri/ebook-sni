<?php

namespace Database\Seeders;

use App\Models\Category;
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
        // User::factory(10)->create();

        $faker = Faker::create();

        // Buat 10 kategori
        foreach (range(1, 13) as $index) {
            Category::create([
                'name' => $faker->word, // Menghasilkan nama kategori acak
            ]);
        }
    }
}
