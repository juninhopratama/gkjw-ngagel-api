<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use app\Http\Models\Post;

class PostContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Post::create([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
            ]);
        }
    }
}
