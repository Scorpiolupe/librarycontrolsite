<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Languages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['name' => 'English', 'code' => 'en'],
            ['name' => 'Spanish', 'code' => 'es'],
            ['name' => 'French', 'code' => 'fr'],
            ['name' => 'German', 'code' => 'de'],
            ['name' => 'Italian', 'code' => 'it'],
            ['name' => 'Chinese', 'code' => 'zh'],
            ['name' => 'Japanese', 'code' => 'ja'],
            ['name' => 'Russian', 'code' => 'ru'],
            ['name' => 'Arabic', 'code' => 'ar'],
            ['name' => 'Portuguese', 'code' => 'pt'],
        ];

        Language::insert($languages);
    }
}
