<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'category_name' => 'Action',
                'description' => 'Film dengan adegan-adegan penuh aksi dan ketegangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Action',
                'description' => 'Film dengan adegan-adegan menghibur dan mengundang tawa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Action',
                'description' => 'Film yang berfokus pada pengembangan karakter dan konflik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Action',
                'description' => 'Film yang berfokus pada latar belakang ilmiah dan teknologi futuristik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Action',
                'description' => 'Film yang berpusat pada kisah cinta dan hubungan romantis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
