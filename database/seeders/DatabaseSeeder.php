<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Post::factory(6)
                ->hasImages(2)
                ->has(Comment::factory(3)->sequence(fn(Sequence $sequence) => 
                    ["parent_id" => $sequence->index !== 0 && $sequence->index !== 1 && $sequence->index !== 2 ? mt_rand(1, 3) : null]
                ))
                ->create();
    }
}
