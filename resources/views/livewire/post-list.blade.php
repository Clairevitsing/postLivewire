<div class="container my-3">
    <div class="row border-bottom py-2">
        <div class="col-xl-11">
            <h4 class="text-center fw-bold"> SPA - CRUD App Using Livewire and Laravel11</h4>
        </div>
    <div class="col-xl-1">
            <a wire:navigate href="{{ route('posts.create') }}" class="btn btn-primary btn-sm"> Add Post</a>
        </div>
    </div>

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
