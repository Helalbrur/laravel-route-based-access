<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LibCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LibCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibCategory::factory()->create([
            'category_name' => 'Leather',
            'short_name'=>'Leather'
        ]);
    }
}
