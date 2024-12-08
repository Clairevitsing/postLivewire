<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostList extends Component
{
    public $posts;
    public function mount(){
        $this->posts = Post::all();

    }
    public function render()
    {
        // dd($this->posts);
        return view('livewire.post-list');
    }
}
