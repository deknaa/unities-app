<x-app-layout>
    <x-navbar></x-navbar>
    <x-toast></x-toast>
    <!-- Main Content -->
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                @foreach ($posts as $post)
                    <div class="card border-0 shadow-sm mb-4 post-card">
                        <div class="card-body p-4">
                            <!-- Post Header -->
                            <div class="d-flex align-items-start mb-3">
                                <div class="position-relative">
                                    <img src="{{ $post->user->avatar_url }}" 
                                         class="rounded-circle border me-3" 
                                         alt="Profile"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="online-indicator"></div>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $post->user->fullname }}</h6>
                                            <div class="d-flex align-items-center">
                                                <small class="text-muted"><span>@</span>{{ $post->user->username }}</small>
                                                <span class="mx-2 text-muted">•</span>
                                                <small class="text-muted">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ $post->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                        
                                        @if (auth()->user()->id == $post->user_id)
                                            <div class="dropdown">
                                                <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" 
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">
                                                                <i class="fas fa-trash-alt me-2"></i>Hapus Postingan
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="post-content">
                                <p class="mb-3 text-break">
                                    {!! preg_replace(
                                        '/\bhttps?:\/\/\S+/i',
                                        '<a href="$0" target="_blank" class="text-primary fw-medium">$0</a>',
                                        e($post->content),
                                    ) !!}
                                </p>

                                <!-- Link Preview -->
                                @if ($post->preview_data)
                                    <a href="{{ $post->preview_data['url'] }}" target="_blank" 
                                       class="text-decoration-none mb-3 d-block link-preview">
                                        <div class="card border rounded-3">
                                            @if ($post->preview_data['image'])
                                                <img src="{{ $post->preview_data['image'] }}"
                                                     class="card-img-top rounded-top"
                                                     style="height: 200px; object-fit: cover;"
                                                     alt="Preview">
                                            @endif
                                            <div class="card-body p-3">
                                                <h6 class="card-title text-dark mb-2 fw-bold">
                                                    {{ $post->preview_data['title'] }}
                                                </h6>
                                                <p class="card-text small text-muted mb-2">
                                                    {{ Str::limit($post->preview_data['description'], 150) }}
                                                </p>
                                                <div class="d-flex align-items-center">
                                                    @if ($post->preview_data['favicon'])
                                                        <img src="{{ $post->preview_data['favicon'] }}"
                                                             width="16" height="16"
                                                             class="me-2 rounded" alt="Favicon">
                                                    @endif
                                                    <small class="text-muted">
                                                        {{ $post->preview_data['provider_name'] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif

                                <!-- Media Content -->
                                @if ($post->media_path)
                                    <div class="post-media mb-3">
                                        @php
                                            $extension = pathinfo($post->media_path, PATHINFO_EXTENSION);
                                        @endphp

                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $post->media_path) }}"
                                                 class="img-fluid rounded-3 w-100"
                                                 style="max-height: 500px; object-fit: cover;"
                                                 alt="Post image">
                                        @elseif (in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                            <div class="ratio ratio-16x9">
                                                <video controls class="rounded-3">
                                                    <source src="{{ asset('storage/' . $post->media_path) }}"
                                                            type="video/{{ $extension }}">
                                                    Browser anda tidak support tag <code>video</code>.
                                                </video>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Post Actions -->
                                <div class="d-flex align-items-center pt-3 border-top">
                                    <div class="d-flex gap-4">
                                        <!-- Comment Button -->
                                        <a href="{{ route('posts.show', $post->id) }}" 
                                           class="btn btn-link text-decoration-none text-muted p-0 action-button">
                                            <i class="far fa-comment me-2"></i>
                                            <span class="small">{{ $post->comments->count() }}</span>
                                        </a>

                                        <!-- Like/Unlike Buttons -->
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-link text-decoration-none text-muted p-0 action-button">
                                                    <i class="far fa-thumbs-up me-2"></i>
                                                    <span>{{ $post->likes->count() }}</span>
                                                </button>
                                            </form>
                                            <form action="{{ route('posts.unlike', $post->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-link text-decoration-none text-muted p-0 action-button">
                                                    <i class="far fa-thumbs-down"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Bookmark Buttons -->
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('posts.bookmark', $post->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-link text-decoration-none text-muted p-0 action-button">
                                                    <i class="far fa-bookmark me-2"></i>
                                                    <span>{{ $post->bookmarks->count() }}</span>
                                                </button>
                                            </form>
                                            <form action="{{ route('posts.unbookmark', $post->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-link text-decoration-none text-muted p-0 action-button">
                                                    <i class="fas fa-bookmark"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- View Detail Button -->
                                    <a href="{{ route('posts.show', $post->id) }}" 
                                       class="btn btn-light btn-sm rounded-pill ms-auto">
                                        <i class="far fa-eye me-1"></i>
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .post-card {
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important;
        }

        .online-indicator {
            width: 12px;
            height: 12px;
            background-color: #28a745;
            border: 2px solid white;
            border-radius: 50%;
            position: absolute;
            bottom: 0;
            right: 12px;
        }

        .action-button {
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            padding: 0.5rem!important;
        }

        .action-button:hover {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd!important;
        }

        .action-button:hover .fa-thumbs-up {
            color: #0d6efd;
        }

        .action-button:hover .fa-thumbs-down {
            color: #dc3545;
        }

        .action-button:hover .fa-bookmark {
            color: #198754;
        }

        .link-preview {
            transition: all 0.3s ease;
        }

        .link-preview:hover {
            transform: translateY(-2px);
        }

        .post-media img,
        .post-media video {
            transition: all 0.3s ease;
        }

        .post-media:hover img,
        .post-media:hover video {
            transform: scale(1.01);
        }

        /* Toast improvements */
        .toast {
            opacity: 0.95;
            backdrop-filter: blur(10px);
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .action-button {
                padding: 0.25rem!important;
            }
        }
    </style>
</x-app-layout>