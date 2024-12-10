<div class="container my-3">
    <div class="row border-bottom py-2">
        <div class="col-xl-11">
            <h4 class="text-center fw-bold"> Posts - CRUD App Using Livewire and Laravel 11</h4>
        </div>
        <div class="col-xl-1">
            <a wire:navigate href="{{ route('posts.create') }}" class="btn btn-primary btn-sm"> Add Post</a>
        </div>
    </div>

    <div class="my-2">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('success') }}
        </div>
        @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('error') }}
        </div>
        @endif

    </div>


    <div class="card">
        <div class="card-body mt-4 table-responsive shadow">

        <div class="col-xl-4 ms-auto my-3">
            <input type="text" wire:model.live.debounce.2000ms="searchTerm" class="class-control" placeholder="Search Post..." />
        </div>
        <table class="table table-striped">
            <thead>
                <th>#</th>
                <th>Featured Image</th>
                <th>Title</th>
                <th>Content</th>
                <th>Date</th>
                <th>Actions</th>
            </thead>



            <tbody>

                @forelse ($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td> <a wire:navigate href="{{ route('posts.view',$post->id)}}"><img src="{{ Storage::url($post->featured_image) }}" class="img-fluid" width="150px"></a></td>

                    <td><a class="text-decoration-none" wire:navigate href="{{ route('posts.view',$post->id)}}">{{ $post->title }}</a></td>
                    <td>{{ $post->content }}</td>
                    <td>
                        <p><small><strong>Posted: </strong>{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</small></p>
                        <p><small><strong>Last Updated: </strong>{{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</small></p>
                    </td>
                    <td>
                        <a href="{{ route('posts.edit', $post->id) }}" wire:navigate class=" btn btn-success btn-sm">Edit</a>
                        <button wire:confirm="Are you sure, you want to delete?" wire:click="deletePost({{ $post->id }})" type="button" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No posts found.</td>
                </tr>
                @endforelse

            </tbody>
        </table>

        {{ $posts->links()}}
    </div>
</div>

</div>