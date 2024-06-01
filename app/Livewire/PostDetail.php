<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Attributes\Computed;
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

    #[Computed]
    public function post(): Post
    {
        return Post::with(['user', 'comments', 'comments.user'])->findOrFail($this->postId);
    }

    public function submit()
    {
        $this->validate();
        $this->post()->comments()->create([
            'user_id' => auth()->user()->id,
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
