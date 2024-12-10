<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;

class PostList extends Component
{
    use WithPagination, WithoutUrlPagination;
    // public $posts;
    // public function mount(){
    //     $this->posts = Post::all();

    // }

    #[Title('Livewire 3 CRUD - Posts Listing')]

    public $searchTerm = null;

    public function render()
    {
        // dd($this->posts);
        $posts = Post::where('title', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('content', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('id', 'DESC')->paginate(5);

        return view('livewire.post-list', compact('posts'));
    }

    public function deletePost(Post $post)
    {
        // dd($id);
        if ($post) {

            if (Storage::exists($post->featured_image)) {
                Storage::exists($post->featured_image);
            }

            $deleteResponse = $post->delete();
            if ($deleteResponse) {
                session()->flash('success', 'Post was deleted successfully!');
            } else {

                session()->flash('error', 'Unable to delete post. Please try again later!');
            }
        } else {
            session()->flash('error', 'Unable to delete post. Please try again!');
        }

        return $this->redirect('/posts', navigate:true);
    }
}