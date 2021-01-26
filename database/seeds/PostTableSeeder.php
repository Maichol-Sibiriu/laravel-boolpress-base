<?php

use Illuminate\Database\Seeder;
use App\post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker  $faker)
    {
        post::truncate();


        for( $i = 0; $i < 10; $i++){
            
            $title = $faker->text(50);

            $newpost = new post();

            $newpost->title = $title;
            $newpost->body = $faker->paragraphs(2, true);
            $newpost->slug = Str::slug($title, '-');

            $newpost->save();
        }
    }
}
