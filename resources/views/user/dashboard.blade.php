<x-app-layout>
    <x-navbar></x-navbar>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <!-- Success Toast -->
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true" id="successToast">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Error Toast -->
        @if (session('error'))
            <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
                aria-atomic="true" id="errorToast">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="container py-3">
        @foreach ($posts as $post)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-3">
                    <!-- Post Header: Profile, Name, Time -->
                    <div class="d-flex align-items-start mb-3">
                        <!-- Profile Picture -->
                        <img src="{{ $post->user->avatar_url }}"
                            class="rounded-circle me-3" alt="Profile"
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
                        <a href="{{ route('posts.show', $post->id) }}"
                            class="btn btn-link text-decoration-none text-muted p-0">
                            <i class="far fa-comment me-2"></i>
                            <span class="small me-3">{{ $post->comments->count() }}</span>
                        </a>

                        <!-- Like Button -->
                        <form action="{{ route('posts.like', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none text-muted p-0">
                                <i class="fa-regular fa-thumbs-up me-2"></i>
                                <span class="me-2">{{ $post->likes->count() }}</span>
                            </button>
                        </form>

                        <form action="{{ route('posts.unlike', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-decoration-none text-muted p-0">
                                <i class="fa-regular fa-thumbs-down me-2"></i>
                            </button>
                        </form>

                        <!-- Bookmark Button -->
                        <form action="{{ route('posts.bookmark', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none text-muted p-0">
                                <i class="fa-solid fa-bookmark me-2"></i>
                                <span class="small me-3">{{ $post->bookmarks->count() }}</span>
                            </button>
                        </form>
                        <form action="{{ route('posts.unbookmark', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-decoration-none text-muted p-0">
                                <i class="far fa-bookmark me-2"></i>
                            </button>
                        </form>

                        <!-- Bookmark Button -->
                        <a href="{{ route('posts.show', $post->id) }}"
                            class="btn btn-link text-decoration-none text-muted ms-auto">
                            <i class="far fa-eye me-1"></i>
                            <span class="small">Lihat Detail</span>
                        </a>
                        {{-- Delet Post button --}}
                        @if (auth()->user()->id == $post->user_id)
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">
                                <i class="fa-solid fa-trash me-2"></i>
                                Hapus Postingan
                            </button>
                        </form>
                        @endif
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi toast jika ada session success atau error
            var successToastEl = document.getElementById('successToast');
            var errorToastEl = document.getElementById('errorToast');

            if (successToastEl) {
                var successToast = new bootstrap.Toast(successToastEl);
                successToast.show();
            }

            if (errorToastEl) {
                var errorToast = new bootstrap.Toast(errorToastEl);
                errorToast.show();
            }
        });
    </script>
</x-app-layout>
