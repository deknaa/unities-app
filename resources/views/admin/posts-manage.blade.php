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

    <div class="container py-5 mt-5">
        <h1>Manage User Posts</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::limit($post->content, 50, '...') }}</td>
                        <td>
                            <img src="{{ $post->user->avatar_url }}" alt="Profile photo"
                                class="rounded-circle object-fit-cover" style="width: 50px; height: 50px;">
                            {{ $post->user->fullname }}
                        </td>
                        <td>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-success text-white" data-bs-toggle="modal"
                                data-bs-target="#postDetailModal-{{ $post->id }}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Post Detail Modal --}}
                    <div class="modal fade" id="postDetailModal-{{ $post->id }}" tabindex="-1"
                        aria-labelledby="postDetailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="postDetailModalLabel">Post Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{-- post detail --}}
                                    <div class="d-flex align-items-start mb-3">
                                        <img src="{{ $post->user->avatar_url }}" alt="Profile photo"
                                            class="rounded-circle me-3"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ $post->user->fullname }}</h6>
                                            <small class="text-muted"><span>@</span>{{ $post->user->username }}</small>
                                            <small
                                                class="text-muted d-block">{{ $post->created_at->format('d M Y, H:i') }}</small>
                                        </div>
                                    </div>

                                    <hr>

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
                                                <a href="{{ $post->preview_data['url'] }}" target="_blank"
                                                    class="text-decoration-none">
                                                    <div class="card border">
                                                        @if ($post->preview_data['image'])
                                                            <img src="{{ $post->preview_data['image'] }}"
                                                                class="card-img-top"
                                                                style="height: 200px; object-fit: cover;"
                                                                alt="Preview">
                                                        @endif
                                                        <div class="card-body p-3">
                                                            <h6 class="card-title text-dark mb-2">
                                                                {{ $post->preview_data['title'] }}
                                                            </h6>
                                                            <p class="card-text small text-muted mb-2">
                                                                {{ Str::limit($post->preview_data['description'], 150) }}
                                                            </p>
                                                            <div class="d-flex align-items-center">
                                                                @if ($post->preview_data['favicon'])
                                                                    <img src="{{ $post->preview_data['favicon'] }}"
                                                                        width="16" height="16" class="me-2"
                                                                        alt="Favicon">
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
                                                    {{-- if the media is an image --}}
                                                    <img src="{{ asset('storage/' . $post->media_path) }}"
                                                        class="img-fluid rounded w-25" alt="Post image">
                                                @elseif (in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                                    {{-- if the media is a video --}}
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
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}
    </div>
</x-app-layout>
