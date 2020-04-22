<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //User Create
        App\User::create([
            'name' => 'zin lynn',
            'email'=> 'zin@gmail.com',
            'password' => bcrypt('zin123')

            ]);

        //Feeds create
        App\Feed::create([
            'user_id'=>1,
            'description'=>'bad Guy',
            'image'=>'/public/images/default.png'
        ]);

        //comment
        App\Comment::create([
            'user_id'=>1,
            'feed_id'=>1,
            'comments'=>'good job'
        ]);

        //Like
        App\Like::create([
            'user_id'=>1,
            'feed_id'=>1,
        ]);
        
    }
}
