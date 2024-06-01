<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    
    public function getPostsProperty()
    {
        return Post::query()->with(['user'])->paginate(3);
    }

    public function render()
    {
        return view('livewire.home');
    }
}
