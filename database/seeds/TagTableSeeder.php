<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        Tag::create([
            'tag' => 'Daily Pup',
        ]);

        factory(Tag::class, 100)->create();
    }
}
