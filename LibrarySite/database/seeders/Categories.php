<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class Categories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::create(['category_name' => 'Bilim']);
        Category::create(['category_name' => 'Edebiyat']);
        Category::create(['category_name' => 'Felsefe']);
        Category::create(['category_name' => 'Teknoloji']);
        Category::create(['category_name' => 'Tarih']);
    }
}
