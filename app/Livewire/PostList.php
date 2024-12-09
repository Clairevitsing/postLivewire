<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class PostList extends Component
{
    use WithPagination, WithoutUrlPagination;
    // public $posts;
    // public function mount(){
    //     $this->posts = Post::all();

    // }
    public function render()
    {
        // dd($this->posts);
        $posts = Post::paginate(5);
        return view('livewire.post-list', compact('posts'));
    }
}
