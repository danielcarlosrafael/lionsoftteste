<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Urgente Site Parou', 
                'category_id' => 1, 
                'description' => 'Meu site parou de funcionar',
                'completed' => 'y'
            ],
            [
                'title' => 'Tela de cadastro de cliente parou', 
                'category_id' => 2, 
                'description' => 'Tela de cadastro de cliente parou',
                'completed' => 'y'
            ],
            [
                'title' => 'Trocar cor da tela de clientes', 
                'category_id' => 3, 
                'description' => 'Trocar cor da tela de clientes',
                'completed' => 'y'
            ],
            [
                'title' => 'Fazer tela de tasks', 
                'category_id' => 4, 
                'description' => 'Fazer tela de tasks',
                'completed' => 'y'
            ],
            [
                'title' => 'Reparo na tela de clientes', 
                'category_id' => 5, 
                'description' => 'Reparar os dados na tela de clientes',
                'completed' => 'y'
            ]
        ];

        Task::insert($tasks);
    }
}
