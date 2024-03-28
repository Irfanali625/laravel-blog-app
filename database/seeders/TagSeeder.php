<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Artificial Intelligence',
            'Space Exploration',
            'Fitness and Nutrition',
            'Finance and Economy',
            'Extreme Sports',
            'Film and TV',
            'Adventure Travel',
            'Gourmet Food',
            'High Fashion',
            'Online Learning',
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag,
            ]);
        }
    }
}
