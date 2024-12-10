<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Models\Post;
use Livewire\Attributes\Title;

class PostForm extends Component
{

    use WithFileUploads;

    #[Title('Livewire 3 CRUD - Manage Posts')]
    public $post=null;
    public $isView = false;

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

    public function mount(Post $post){
        $this->isView = request()->routeIs('posts.view');
        // dd($post);
        if($post->id){
            $this->post = $post;
            $this->title = $post->title;
            $this->content = $post->content;
        }
    }

    public function savePost(){
        // dd($this->title);
        //  dd($this->post);

        $this->validate();

        $rules = [
            'featuredImage' => $this->post && $this->post->featured_image ? 'nullable|image|mimes:jpg,jpeg,png,svg,bmp,webp,gif|max:2048' :  'required|image|mimes:jpg,jpeg,png,svg,bmp,webp,gif|max:2048'
        ];

        $messages = [
            'featuredImage.required' => 'Featured image is required',
            'featuredImage.image' => 'Featured Image must be a valid image',
            'featuredImage.mimes' => 'Featured Image accepts only jpg, jpeg, png, svg, bmp, webp and gif',
            'featuredImage.max' => 'Featured Image must not be a larger than 2MB',
        ];
         
        $this->validate($rules, $messages);



        $imagePath = null;
        // dd($this->featuredImage);
        if ($this->featuredImage) {
            $imageName = time().'.'.$this->featuredImage->extension();
            $imagePath = $this->featuredImage->storeAs('public/uploads', $imageName);
        }


         if($this->post){
            $this->post->title = $this->title;
            $this->post->content = $this->content;

            if($imagePath){
                $this->post->featured_image = $imagePath;
            }

            #Update Functionality
            $updatePost = $this->post->save();

            if($updatePost){
                session()->flash('success','Post have been saved successfully!');
            } else {
                session()->flash('error','Unable to save post. Please try again!');
            }
        } else {

            $post = Post::create([
                'title' => $this->title,
                'content' => $this->content,
                'featured_image' => $imagePath,
            ]);

            if ($post) {
                session()->flash('success', 'Post has been published successfully!');
            } else {
                session()->flash('error', 'Unable to create post! Please try again');
            }

        }

        return $this->redirect('/posts',navigate: true);
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}
