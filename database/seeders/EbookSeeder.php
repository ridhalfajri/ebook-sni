<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {
            Ebook::create([
                'category_id' => Category::inRandomOrder()->first()->id, // Random category
                'title' => $faker->sentence(3),
                'author' => $faker->name,
                'price' => $faker->numberBetween(100001, 500000),
                'description' => $faker->paragraph,
                'file_path' => 'path/to/ebook' . $i . '.pdf',
                'thumbnail' => 'path/to/thumbnail' . $i . '.jpg',
            ]);
        }
    }
}
