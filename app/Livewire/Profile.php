<?php

namespace App\Livewire;

use App\Models\Post;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Profile extends Component
{
    use InteractsWithBanner;
    use WithPagination;
    use WithFileUploads;

    public $showForm = false;
    public $title;
    public $content;
    public $images = [];

    public $rules = [
        'title' => ['required'],
        'content' => ['required'],
        'images' => ['array', 'max:6'],
        'images.*' => 'image|max:1024|mimes:png,jpg,jpeg',
    ];

    public function getUserProperty()
    {
        return auth()->user();
    }
    
    public function getPostsProperty()
    {
        return $this->user->posts()->latest()->paginate(6);
    }

    public function updated($property)
    {
        if($property == 'images') {
            $this->validate([
                'images' => ['array', 'max:6'],
                'images.*' => 'image|max:1024|mimes:png,jpg,jpeg',
            ]);
        }
    }

    public function submit()
    {

        $this->validate();
        $post = $this->user->posts()->create([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        if(is_array($this->images)) {
            foreach ($this->images as $image) {
                $imgName = $image->store('images', 'public');
                $post->images()->create([
                    'path' => $imgName
                ]);
            }
        }

        $this->banner('Created Successfully.');
        $this->title = null;
        $this->content = null;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
