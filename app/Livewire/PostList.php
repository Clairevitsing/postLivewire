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
    public $activePageNumber = 1;

    public function fetchPosts(){
        return Post::where('title', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('content', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('id', 'DESC')->paginate(5);
    }


    public function render()
    {
        // dd($this->posts);
        $posts=$this->fetchPosts();
       
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

        $posts = $this->fetchPosts();

        if ($posts->isEmpty() && $this->activePageNumber > 1) {
            //Redirect to the active page after the post was deleted
            $this->gotoPage($this->activePageNumber - 1);
            // return $this->redirect('/posts', navigate:true);
        }
        //Redirect to the active page after the post was deleted
        $this->gotoPage($this->activePageNumber);
        // return $this->redirect('/posts', navigate:true);
    }

    //Track the active page from pagination
    public function updatingPage($pageNumber){
        $this->activePageNumber = $pageNumber;
    }


}