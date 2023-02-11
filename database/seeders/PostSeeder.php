<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author = User::create([
            'name' => 'Mohed Alrahbi',
            'email' => 'mccdama@gmail.com',
            'password' => bcrypt('test'),
            'email_verified_at' => now(),
        ]);

        $commenter = User::create([
            'name' => 'Ajassem Rah',
            'email' => 'mccdama@outlook.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $tag1 = Tag::create(['name' => 'Laravel']);
        $tag2 = Tag::create(['name' => 'JSON:API']);

        $post = new Post([
            'title' => 'Laravel JSON:API',
            'published_at' => now(),
            'content' => 'learn all about Laravel JSON:API...',
            'slug' => 'laravel-jsonapi',
        ]);


        $post->author()->associate($author)->save();
        $post->tags()->saveMany([$tag1, $tag2]);

        $comment = new Comment([
            'content' => 'Looking forward to more!',
        ]);

        $comment->post()->associate($post);
        $comment->user()->associate($commenter)->save();
    }
}
