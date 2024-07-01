<?php

namespace App\Livewire;

use App\Actions\Startup\AddComment;
use App\Actions\Startup\ToggleVote;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class PostDetail extends Component
{
    use InteractsWithBanner;

    public $postId;
    public $content;
    public $showForm = false;
    public $backPageRoute;

    public $rules = [
        'content' => ['required']
    ];

    public function mount()
    {
        $previousRouteName = Route::getRoutes()->match(
            Request::create(URL::previous())
        )->getName();
        $currentRouteName = Route::currentRouteName();
        if($previousRouteName == $currentRouteName) {
            $route = Cache::get('previous_route');
            $this->backPageRoute = $route;
        }else {
            $this->backPageRoute = url()->previous();
            Cache::put('previous_route', $this->backPageRoute, now()->addDay());
        }
    }

    #[On('echo:vote-created,VoteCreated')]
    #[On('echo:vote-deleted,VoteDeleted')]
    #[On('echo:comment-created,CommentCreated')]
    public function refresh()
    {
    }

    #[Computed]
    public function post(): Post
    {
        return Post::with(['user', 'comments', 'comments.user'])->findOrFail($this->postId);
    }

    public function submit(AddComment $addComment)
    {
        $this->validate();
        $addComment->add($this->post(), $this->content);
        $this->banner('Your comment posted.');
        $this->content = null;
        $this->showForm = false;
    }

    public function vote(ToggleVote $toggleVote)
    {
        $toggleVote->toggle($this->post());
    }

    public function render()
    {
        return view('livewire.post-detail');
    }
}
