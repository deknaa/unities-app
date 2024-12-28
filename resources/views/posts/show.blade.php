<x-app-layout>
    <x-navbar></x-navbar>
    <div class="container py-3">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-3">
                <!-- Post Header: Profile, Name, Time -->
                <div class="d-flex align-items-start mb-3">
                    <!-- Profile Picture -->
                    <img src="{{ $post->user->avatar }}" class="rounded-circle me-3" alt="Profile"
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

                {{-- post content --}}
                <div class="post-content mb-3">
                    {{-- text content --}}
                    <p class="mb-3">
                        {!! preg_replace(
                            '/\bhttps?:\/\/\S+/i',
                            '<a href="$0" target="_blank" class="text-primary text-decoration-none">$0</a>',
                            e($post->content),
                        ) !!}
                        @if ($post->preview_data)
                            <a href="{{ $post->preview_data['url'] }}" target="_blank" class="text-decoration-none">
                                <div class="card border">
                                    @if ($post->preview_data['image'])
                                        <img src="{{ $post->preview_data['image'] }}" class="card-img-top"
                                            style="height: 200px; object-fit: cover;" alt="Preview">
                                    @endif
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-dark mb-2">{{ $post->preview_data['title'] }}
                                        </h6>
                                        <p class="card-text small text-muted mb-2">
                                            {{ Str::limit($post->preview_data['description'], 150) }}
                                        </p>
                                        <div class="d-flex align-items-center">
                                            @if ($post->preview_data['favicon'])
                                                <img src="{{ $post->preview_data['favicon'] }}" width="16"
                                                    height="16" class="me-2" alt="Favicon">
                                            @endif
                                            <small
                                                class="text-muted">{{ $post->preview_data['provider_name'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    </p>

                    @if ($post->media_path)
                        {{-- gambar/video content --}}
                        <div class="post-media mb-3 text-center">
                            @php
                                $extension = pathinfo($post->media_path, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                <!-- If the media is an image -->
                                <img src="{{ asset('storage/' . $post->media_path) }}"
                                    class="img-fluid rounded w-25" alt="Post image">
                            @elseif (in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                <!-- If the media is a video -->
                                <video controls class="img-fluid rounded w-50">
                                    <source src="{{ asset('storage/' . $post->media_path) }}"
                                        type="video/{{ $extension }}">
                                    Browser anda tidak support tag <code>video</code>.
                                </video>
                            @else
                                <p class="text-muted">File tidak dapat ditampilkan.</p>
                            @endif
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
                    <button class="btn btn-link text-decoration-none text-muted p-0">
                        <i class="far fa-heart me-2"></i>
                        <span class="small me-3">{{ $post->likes->count() }}</span>
                    </button>

                    <!-- Bookmark Button -->
                    <button class="btn btn-link text-decoration-none text-muted p-0">
                        <i class="far fa-bookmark me-2"></i>
                        <span class="small me-3">{{ $post->bookmarks->count() }}</span>
                    </button>

                    <!-- Bookmark Button -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn btn-link text-decoration-none text-muted ms-auto">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        <span class="small">Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <h2>Buat Komentar</h2>
        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea class="form-control" name="content" rows="3" placeholder="Ketik komentar..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        </form>

        @foreach ($post->comments as $comment)
            <div class="mt-3">
                <strong>{{ $comment->user->fullname }}</strong>
                <p>{{ $comment->content }}</p>
                <form action="{{ route('comments.reply', $comment->id) }}" method="POST" class="mt-2">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control" name="content" rows="2" placeholder="Balas komentar ini..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm">Balas Komentar</button>
                </form>

                @if ($comment->replies->count())
                    <div class="ms-4">
                        @foreach ($comment->replies as $reply)
                            <div class="mt-2">
                                <strong>{{ $reply->user->fullname }}</strong>
                                <div class="post-content mb-3">
                                    {{-- text content --}}
                                    <p class="mb-3">
                                        {!! preg_replace(
                                            '/\bhttps?:\/\/\S+/i',
                                            '<a href="$0" target="_blank" class="text-primary text-decoration-none">$0</a>',
                                            e($reply->content),
                                        ) !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

    </div>

    <style>
        /* Custom Styles */
        .card {
            border-radius: 15px;
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
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
