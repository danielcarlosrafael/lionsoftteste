<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Urgente'],
            ['name' => 'Média Urgência'],
            ['name' => 'Baixa Urgência'],
            ['name' => 'Nova Feature'],
            ['name' => 'Reparo']
        ];

        Category::insert($categories);
    }
}
