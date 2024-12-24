<x-app-layout>
    <x-navbar></x-navbar>
    {{-- <div class="container">
        <h1>All Posts</h1>
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->user->fullname }}</h5>
                    <p class="card-text">{{ $post->content }}</p>
                    @if($post->media_path)
                        <p class="text-center"><img src="{{ asset('storage/' . $post->media_path) }}" alt="Media" class="img-fluid w-25"></p>
                    @endif
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View</a>
                </div>
            </div>
        @endforeach
    
        {{ $posts->links() }}
    </div> --}}
    <div class="container py-3">
        @foreach ($posts as $post)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-3">
                <!-- Post Header: Profile, Name, Time -->
                <div class="d-flex align-items-start mb-3">
                    <!-- Profile Picture -->
                    <img src="{{ $post->user->avatar }}" 
                         class="rounded-circle me-3" 
                         alt="Profile" 
                         style="width: 48px; height: 48px; object-fit: cover;">
                    
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <!-- Name and Username -->
                                <h6 class="mb-0 fw-bold">{{ $post->user->fullname }}</h6>
                                <small class="text-muted"><span>@</span>{{ $post->user->username }}</small>
                            </div>
                            
                            <!-- Timestamp -->
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
    
                <!-- Post Content -->
                <div class="post-content mb-3">
                    <!-- Text Content -->
                    <p class="mb-3">
                        {{ $post->content }}
                    </p>
    
                    @if($post->media_path)
                    <!-- Media Content (if any) -->
                    <div class="post-media mb-3 text-center">
                        <img src="{{ asset('storage/' . $post->media_path) }}" 
                             class="img-fluid rounded w-25" 
                             alt="Post image">
                    </div>
                    @endif
                </div>
    
                <!-- Post Actions -->
                <div class="d-flex align-items-center border-top pt-3">
                    <!-- Comment Button -->
                    <button class="btn btn-link text-decoration-none text-muted p-0">
                        <i class="far fa-comment me-2"></i>
                        <span class="small me-3">{{ $post->comments->count() }}</span>
                    </button>
    
                    <!-- Like Button -->
                    {{-- <button class="btn btn-link text-decoration-none text-muted p-0">
                        <i class="far fa-heart me-2"></i>
                        <span class="small me-3">{{ $post->likes->count() }}</span>
                    </button> --}}
                    <form action="{{ route('posts.like', $post->id) }}" method="POST" class="d-flex">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none text-muted p-0"><i class="fa-regular fa-thumbs-up me-2"></i></button>
                        <p>{{ $post->likes->count() }}</p>
                    </form>
                    
                    <form action="{{ route('posts.unlike', $post->id) }}" method="POST" class="d-flex">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-decoration-none text-muted p-0"><i class="fa-regular fa-thumbs-down me-2"></i></button>
                        <p>0</p>
                    </form>
    
                    <!-- Bookmark Button -->
                    <button class="btn btn-link text-decoration-none text-muted p-0">
                        <i class="far fa-bookmark me-2"></i>
                        <span class="small me-3">{{ $post->bookmarks->count() }}</span>
                    </button>

                    <!-- Bookmark Button -->
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-link text-decoration-none text-muted ms-auto">
                        <i class="far fa-eye me-1"></i>
                        <span class="small">Lihat Detail</span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        {{ $posts->links() }}
    </div>
    
    <style>
        /* Custom Styles */
        .card {
            border-radius: 15px;
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
        }
    
        .btn-link {
            transition: all 0.2s ease;
        }
    
        .btn-link:hover {
            color: #0d6efd !important;
            transform: scale(1.05);
        }
    
        .btn-link:hover .fa-heart {
            color: #dc3545;
        }
    
        .btn-link:hover .fa-bookmark {
            color: #198754;
        }
    
        .post-media {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }
    
        .post-media img {
            width: 100%;
            transition: transform 0.3s ease;
        }
    
        .post-media:hover img {
            transform: scale(1.02);
        }
    
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-body {
                padding: 1rem;
            }
        }
    </style>
</x-app-layout>