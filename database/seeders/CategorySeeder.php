<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() :void
    {
        // Create five categories with names and descriptions
        Category::create([
            'name' => 'Mystery',
            'description' => 'A genre that involves solving a crime or unraveling a puzzle.'
        ]);
        Category::create([
            'name' => 'Science Fiction',
            'description' => 'A genre that explores futuristic concepts and advanced technology.'
        ]);
        Category::create([
            'name' => 'Fantasy',
            'description' => 'A genre that features magical elements and fantastical creatures.'
        ]);
        Category::create([
            'name' => 'Romance',
            'description' => 'A genre that focuses on romantic relationships between characters.'
        ]);
        Category::create([
            'name' => 'Horror',
            'description' => 'A genre intended to frighten, scare, or disgust the audience.'
        ]);
    }
}
