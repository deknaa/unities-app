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
        <h3 class="mb-4">Postingan Yang Anda Disimpan</h3>
        @if ($bookmarks->count() > 0)
            @foreach ($bookmarks as $bookmark)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3">
                        <!-- Header: Nama dan Avatar Pembuat Postingan -->
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{ $bookmark->post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($bookmark->post->user->fullname) }}"
                                class="rounded-circle me-3" alt="Profile"
                                style="width: 48px; height: 48px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $bookmark->post->user->fullname }}</h6>
                                <small class="text-muted"><span>@</span>{{ $bookmark->post->user->username }}</small>
                            </div>
                        </div>

                        <!-- Konten Postingan -->
                        <div class="post-content mb-3">
                            <p class="mb-3">
                                {!! preg_replace(
                                    '/\bhttps?:\/\/\S+/i',
                                    '<a href="$0" target="_blank" class="text-primary text-decoration-none">$0</a>',
                                    e($bookmark->post->content),
                                ) !!}
                                @if ($bookmark->post->preview_data)
                                    <a href="{{ $bookmark->post->preview_data['url'] }}" target="_blank"
                                        class="text-decoration-none">
                                        <div class="card border">
                                            @if ($bookmark->post->preview_data['image'])
                                                <img src="{{ $bookmark->post->preview_data['image'] }}"
                                                    class="card-img-top" style="height: 200px; object-fit: cover;"
                                                    alt="Preview">
                                            @endif
                                            <div class="card-body p-3">
                                                <h6 class="card-title text-dark mb-2">
                                                    {{ $bookmark->post->preview_data['title'] }}
                                                </h6>
                                                <p class="card-text small text-muted mb-2">
                                                    {{ Str::limit($bookmark->post->preview_data['description'], 150) }}
                                                </p>
                                                <div class="d-flex align-items-center">
                                                    @if ($bookmark->post->preview_data['favicon'])
                                                        <img src="{{ $bookmark->post->preview_data['favicon'] }}"
                                                            width="16" height="16" class="me-2" alt="Favicon">
                                                    @endif
                                                    <small
                                                        class="text-muted">{{ $bookmark->post->preview_data['provider_name'] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </p>

                            <!-- Media jika ada -->
                            @if ($bookmark->post->media_path)
                                <div class="post-media mb-3 text-center">
                                    <img src="{{ asset('storage/' . $bookmark->post->media_path) }}"
                                        class="img-fluid rounded w-50" alt="Post Image">
                                </div>
                            @endif

                            <!-- Tombol untuk Hapus Bookmark -->
                            <form action="{{ route('posts.unbookmark', $bookmark->post->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-bookmark me-2"></i>
                                    Hapus Bookmark
                                </button>
                            </form>
                        </div>
                    </div>
            @endforeach
        @else
            <p class="text-muted">Belum ada postingan yang disimpan.</p>
        @endif
    </div>
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
