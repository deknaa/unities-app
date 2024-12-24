<x-app-layout>
    <x-navbar></x-navbar>
    <div class="container">
        <h1>Create Post</h1>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="media" class="form-label">Media (Optional)</label>
                <input class="form-control" type="file" id="media" name="media">
            </div>
            <button type="submit" class="btn btn-success">Post</button>
        </form>
    </div>
</x-app-layout>