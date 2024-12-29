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

    <!-- Main Content -->
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <!-- Page Header -->
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-bookmark fs-3 text-primary me-3"></i>
                    <h3 class="mb-0">Postingan Yang Anda Disimpan</h3>
                </div>

                <!-- Bookmarks List -->
                @if ($bookmarks->count() > 0)
                    <div class="bookmark-list">
                        @foreach ($bookmarks as $bookmark)
                            <div class="card border-0 shadow-sm mb-4 rounded-3 hover-shadow">
                                <div class="card-body p-4">
                                    <!-- Post Author -->
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $bookmark->post->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($bookmark->post->user->fullname) }}"
                                            class="rounded-circle me-3 border" alt="Profile"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $bookmark->post->user->fullname }}</h6>
                                            <small class="text-muted">
                                                <span>@</span>{{ $bookmark->post->user->username }}
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <div class="post-content">
                                        <p class="mb-3 text-break">
                                            {!! preg_replace(
                                                '/\bhttps?:\/\/\S+/i',
                                                '<a href="$0" target="_blank" class="text-primary fw-medium">$0</a>',
                                                e($bookmark->post->content),
                                            ) !!}
                                        </p>

                                        <!-- Link Preview Card -->
                                        @if ($bookmark->post->preview_data)
                                            <a href="{{ $bookmark->post->preview_data['url'] }}" target="_blank"
                                                class="text-decoration-none mb-3 d-block">
                                                <div class="card border rounded-3 hover-shadow-sm">
                                                    @if ($bookmark->post->preview_data['image'])
                                                        <img src="{{ $bookmark->post->preview_data['image'] }}"
                                                            class="card-img-top rounded-top"
                                                            style="height: 200px; object-fit: cover;" alt="Preview">
                                                    @endif
                                                    <div class="card-body p-3">
                                                        <h6 class="card-title text-dark mb-2 fw-bold">
                                                            {{ $bookmark->post->preview_data['title'] }}
                                                        </h6>
                                                        <p class="card-text small text-muted mb-2">
                                                            {{ Str::limit($bookmark->post->preview_data['description'], 150) }}
                                                        </p>
                                                        <div class="d-flex align-items-center">
                                                            @if ($bookmark->post->preview_data['favicon'])
                                                                <img src="{{ $bookmark->post->preview_data['favicon'] }}"
                                                                    width="16" height="16"
                                                                    class="me-2 rounded-circle" alt="Favicon">
                                                            @endif
                                                            <small class="text-muted">
                                                                {{ $bookmark->post->preview_data['provider_name'] }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif

                                        <!-- Media Content -->
                                        @if ($bookmark->post->media_path)
                                            <div class="post-media mb-3">
                                                @php
                                                    $extension = pathinfo($bookmark->post->media_path, PATHINFO_EXTENSION);
                                                @endphp

                                                @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ asset('storage/' . $bookmark->post->media_path) }}"
                                                        class="img-fluid rounded-3" alt="Post image">
                                                @elseif (in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                                    <div class="ratio ratio-16x9">
                                                        <video controls class="rounded-3">
                                                            <source src="{{ asset('storage/' . $bookmark->post->media_path) }}"
                                                                type="video/{{ $extension }}">
                                                            Browser anda tidak support tag <code>video</code>.
                                                        </video>
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning mb-0">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        File tidak dapat ditampilkan.
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Action Buttons -->
                                        <div class="mt-3">
                                            <form action="{{ route('posts.unbookmark', $bookmark->post->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fa-solid fa-bookmark me-2"></i>
                                                    Hapus Bookmark
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bookmark text-muted mb-3 fs-1"></i>
                        <p class="text-muted mb-0">Belum ada postingan yang disimpan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .hover-shadow {
            transition: box-shadow 0.3s ease;
        }
        .hover-shadow:hover {
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        .hover-shadow-sm:hover {
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
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
