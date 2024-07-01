<?php

namespace App\Actions\Startup;

use App\Models\Comment;
use App\Models\Post;

class AddComment {
    public function add(Post $post, $content)
    {
        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'content' => $content,
        ]);
    }
}