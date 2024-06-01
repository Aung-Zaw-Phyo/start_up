<?php

namespace App\Livewire;

use App\Models\Post;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PostDetail extends Component
{
    use InteractsWithBanner;

    public $postId;
    public $content;
    public $showForm = false;

    public $rules = [
        'content' => ['required']
    ];

    #[Computed]
    public function post(): Post
    {
        return Post::with(['user', 'comments', 'comments.user'])->findOrFail($this->postId);
    }

    public function submit()
    {
        $this->validate();
        $this->post()->comments()->create([
            'user_id' => 1,
            'content' => $this->content,
        ]);
        $this->banner('Your comment posted.');
        $this->content = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.post-detail');
    }
}
