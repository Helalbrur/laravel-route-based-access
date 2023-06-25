<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LibItemCategoryList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LibItemCategoryListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibItemCategoryList::factory()->create([
            'category_id' => 113,
            'actual_category_name' => 'Leather',
            'short_name'=>'Leather'
        ]);
    }
}
