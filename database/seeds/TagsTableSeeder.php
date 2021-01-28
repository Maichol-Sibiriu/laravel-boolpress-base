<?php

use Illuminate\Database\Seeder;
use App\Tag;
use PhpParser\Node\Stmt\Foreach_;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'educational',
            'laravel',
            'html',
            'php',
        ];

        foreach($tags as $tag){
              
            $newTag = new Tag();

            $newTag->name = $tag;

            $newTag->save();
        }

    }
}
