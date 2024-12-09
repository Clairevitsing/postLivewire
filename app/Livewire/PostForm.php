<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Models\Post;

class PostForm extends Component
{

    use WithFileUploads;

    #[validate('required', message:"Post title is required")]
    #[validate('min:3', message:"Post title must be at least 3 characters")]
    #[validate('max:150', message:"Post title must not exceed 150 characters")]
    public $title;

    #[validate('required', message:"Post content is required")]
    #[validate('min:10', message:"Post content must be at least 10 characters")]
    public $content;
    
    #[validate('required', message:"Featured Image is required")]
    #[validate('image', message:"Featured image must be a valid Image")]
    #[validate('mimes:jpg,jpeg,png,svg,bmp,webp,gif', message:"Featured image accepts only jpg, jpeg, png, svg, bmp, webp, gif")]
    #[validate('max:2048', message:"Featured image must be less than 2M")]
    public $featuredImage;

    public function savePost(){
        // dd($this->title);
        $this->validate();

        $imagePath = null;

        // dd($this->featuredImage);
        if ($this->featuredImage) {
            $imageName = time() . '-' . $this->featuredImage->extension();
            $imagePath = $this->featuredImage->storeAs('public/uploads', $imageName);
        }

        $post = Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'featured_image' => $imagePath,
        ]);

        if($post){
            session()->flash('success', 'Post has been published successfully!');
        }
        else {
            session()->flash('error', 'Unable to create post! Please try again');
        }

        return $this->redirect('/posts',navigate: true);
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}
