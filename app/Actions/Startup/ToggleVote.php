<?php

namespace App\Actions\Startup;

use App\Events\VoteDeleted;
use App\Models\Post;
use App\Models\Vote;

class ToggleVote {
    public function toggle(Post $post) 
    {
        $vote = Vote::where([
            "user_id" => auth()->id(),
            "post_id" => $post->id,
        ])->first();
    
        if ($vote) {
            $vote->delete();
        } else {
            $vote = Vote::create([
                "user_id" => auth()->id(),
                "post_id" => $post->id,
            ]);
        }
    }
}