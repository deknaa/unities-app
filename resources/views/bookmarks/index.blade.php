<x-app-layout>
    <x-navbar></x-navbar>
    <div class="container">
        <h1>Postingan yang anda bookmarks</h1>
        <ul class="list-group">
            @foreach ($bookmarks as $bookmark)
                <li class="list-group-item mb-2">
                    <!-- Post Header: Profile, Name, Time -->
                    <div class="d-flex align-items-start mb-3">
                        <!-- Profile Picture -->
                        <img src="{{ $bookmark->user->avatar }}" class="rounded-circle me-3" alt="Profile"
                            style="width: 48px; height: 48px; object-fit: cover;">

                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <!-- Name and Username -->
                                    <h6 class="mb-0 fw-bold">{{ $bookmark->user->fullname }}</h6>
                                    <small class="text-muted"><span>@</span>{{ $bookmark->user->username }}</small>
                                </div>

                                <!-- Timestamp -->
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>{{ $bookmark->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('posts.show', $bookmark->post->id) }}"
                            class="btn btn-link text-decoration-none text-muted">
                            <i class="far fa-eye me-1"></i>
                            <span class="small">Lihat Detail</span>
                        </a>
                        <form action="{{ route('posts.unbookmark', $bookmark->post->id) }}" method="POST"
                            class="d-inline ms-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-decoration-none text-muted ms-auto">
                                <i class="fa-solid fa-bookmark me-2"></i>
                                <span class="small me-3">Hapus Bookmark</span>
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
