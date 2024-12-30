<x-app-layout>
    <x-navbar></x-navbar>
    <x-toast></x-toast>
    <div class="container py-5 mt-5">
        <!-- Main Post Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <!-- Post Header -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="position-relative">
                                <img src="{{ $post->user->avatar_url }}" class="rounded-circle border me-3" alt="Profile"
                                    width="52" height="52" style="object-fit: cover;">
                                <div class="online-indicator"></div>
                            </div>

                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0 fw-bold">{{ $post->user->fullname }}</h5>
                                        <div class="text-muted small">
                                            <span>@</span>{{ $post->user->username }}
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted small">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="post-content mb-4">
                            <p class="fs-6 mb-3">
                                {!! preg_replace(
                                    '/\bhttps?:\/\/\S+/i',
                                    '<a href="$0" target="_blank" class="text-primary text-decoration-none">$0</a>',
                                    e($post->content),
                                ) !!}
                            </p>

                            @if ($post->preview_data)
                                <a href="{{ $post->preview_data['url'] }}" target="_blank"
                                    class="text-decoration-none link-preview">
                                    <div class="card border bg-light">
                                        @if ($post->preview_data['image'])
                                            <img src="{{ $post->preview_data['image'] }}"
                                                class="card-img-top preview-image" alt="Preview">
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
                                                    <img src="{{ $post->preview_data['favicon'] }}" width="16"
                                                        height="16" class="me-2" alt="Favicon">
                                                @endif
                                                <small class="text-muted">
                                                    {{ $post->preview_data['provider_name'] }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            @if ($post->media_path)
                                <div class="post-media mt-3">
                                    @php
                                        $extension = pathinfo($post->media_path, PATHINFO_EXTENSION);
                                    @endphp

                                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $post->media_path) }}"
                                            class="img-fluid rounded" alt="Post image" data-bs-toggle="modal"
                                            data-bs-target="#imageModal">
                                    @elseif (in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                        <div class="ratio ratio-16x9">
                                            <video controls class="rounded">
                                                <source src="{{ asset('storage/' . $post->media_path) }}"
                                                    type="video/{{ $extension }}">
                                                Your browser doesn't support video playback.
                                            </video>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Post Actions -->
                        <div class="d-flex align-items-center pt-3 border-top">
                            <div class="d-flex gap-4">
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

                            <div class="ms-auto d-flex gap-2">
                                @if (auth()->user()->id == $post->user_id)
                                    <form action="{{ route('posts.destroy.user', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-light text-danger btn-sm rounded-pill ms-auto"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">
                                            <i class="fas fa-trash-alt me-2"></i>Hapus Postingan
                                        </button>
                                    </form>
                                @endif
                                <!-- Back Button -->
                                <a href="{{ route('dashboard', $post->id) }}"
                                    class="btn btn-light btn-sm rounded-pill ms-auto">
                                    <i class="fa-solid fa-arrow-left me-1"></i>
                                    Back
                                </a>
                            </div>
                        </div>

                        <!-- Comment Form -->
                        <div class="mb-4 mt-4">
                            <h5 class="mb-3">Leave a Comment</h5>
                            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" name="content" rows="3" placeholder="Write your comment..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary px-4">
                                    Post Comment
                                </button>
                            </form>
                        </div>

                        {{-- Comments --}}
                        <div class="comments">
                            <h5 class="mb-4">Comments ({{ $totalComments }})</h5>
                            @foreach ($post->comments as $comment)
                                <div class="comment mb-4">
                                    <div class="d-flex mb-3">
                                        <img src="{{ $comment->user->avatar_url }}" class="rounded-circle me-2"
                                            width="40" height="40" alt="{{ $comment->user->fullname }}">
                                        <div class="flex-grow-1">
                                            <div class="bg-light rounded-3 p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">{{ $comment->user->fullname }}</h6>
                                                    <div class="d-flex align-items-center">
                                                        <small class="text-muted me-3">
                                                            {{ $comment->created_at->diffForHumans() }}
                                                        </small>
                                                        @if (auth()->user()->id === $comment->user_id || auth()->user()->is_admin)
                                                            <form
                                                                action="{{ route('comments.destroy', $comment->id) }}"
                                                                method="POST" class="delete-comment-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-link text-danger p-0 btn-sm"
                                                                    onclick="return confirm('Anda yakin ingin menghapus komentar ini?')">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="mb-0">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reply Form -->
                                    <div class="reply-form ms-5 mb-3" id="reply-form-{{ $comment->id }}">
                                        <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-2">
                                                <textarea class="form-control form-control-sm" name="content" rows="2" placeholder="Write your reply..."
                                                    required></textarea>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="reset"
                                                    class="btn btn-link btn-sm text-decoration-none me-2 cancel-reply"
                                                    data-comment-id="{{ $comment->id }}">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    Reply
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Replies -->
                                    @if ($comment->replies->count())
                                        <div class="ms-5">
                                            @foreach ($comment->replies as $reply)
                                                <div class="d-flex mb-3">
                                                    <img src="{{ $reply->user->avatar_url }}"
                                                        class="rounded-circle me-2" width="32" height="32"
                                                        alt="{{ $reply->user->fullname }}">
                                                    <div class="flex-grow-1">
                                                        <div class="bg-light rounded-3 p-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <h6 class="mb-0 small">{{ $reply->user->fullname }}
                                                                </h6>
                                                                <div class="d-flex align-items-center">
                                                                    <small class="text-muted me-3">
                                                                        {{ $reply->created_at->diffForHumans() }}
                                                                    </small>
                                                                    @if (auth()->user()->id === $reply->user_id || auth()->user()->role === 'admin')
                                                                        <form
                                                                            action="{{ route('comments.destroy', $reply->id) }}"
                                                                            method="POST" class="delete-reply-form">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-link text-danger p-0 btn-sm"
                                                                                onclick="return confirm('Anda yakin ingin menghapus pesan ini?')">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <p class="mb-0 small">{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img src="" class="img-fluid" alt="Full size image">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    /* Enhanced Custom Styles */
    .card {
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .preview-image {
        height: 200px;
        object-fit: cover;
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

    .link-preview {
        display: block;
        transition: transform 0.2s ease;
    }

    .link-preview:hover {
        transform: translateY(-2px);
    }

    .post-media img {
        cursor: pointer;
        transition: opacity 0.2s ease;
    }

    .post-media img:hover {
        opacity: 0.95;
    }

    .btn-link {
        transition: all 0.2s ease;
    }

    .btn-link:hover {
        transform: scale(1.05);
    }

    .btn-link:hover .fa-heart {
        color: #dc3545 !important;
    }

    .btn-link:hover .fa-bookmark {
        color: #198754 !important;
    }

    .btn-link:hover .fa-comment {
        color: #0d6efd !important;
    }

    .comment .bg-light {
        background-color: #f8f9fa !important;
        transition: background-color 0.2s ease;
    }

    .comment .bg-light:hover {
        background-color: #f0f1f2 !important;
    }

    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .card-body {
            padding: 1rem !important;
        }

        .post-media img {
            border-radius: 0.5rem;
        }
    }

    .action-button {
        transition: all 0.2s ease;
        border-radius: 0.5rem;
        padding: 0.5rem !important;
    }

    .action-button:hover {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd !important;
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

    .delete-comment-form button,
    .delete-reply-form button {
        opacity: 0.7;
        transition: all 0.2s ease;
    }

    .delete-comment-form button:hover,
    .delete-reply-form button:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    .bg-light:hover .delete-comment-form button,
    .bg-light:hover .delete-reply-form button {
        opacity: 1;
    }
</style>

<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
                // Handle reply toggle
                document.addEventListener('DOMContentLoaded', function() {
                    var tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    tooltips.map(function(tooltip) {
                        return new bootstrap.Tooltip(tooltip)
                    });

                    // Handle reply toggle
                    document.querySelectorAll('.reply-toggle').forEach(button => {
                        button.addEventListener('click', function() {
                            const commentId = this.dataset.commentId;
                            const replyForm = document.querySelector(
                                `#reply-form-${commentId}`);
                            replyForm.classList.toggle('d-none');
                        });
                    });

                    // Handle cancel reply
                    document.querySelectorAll('.cancel-reply').forEach(button => {
                        button.addEventListener('click', function() {
                            const commentId = this.dataset.commentId;
                            const replyForm = document.querySelector(
                                `#reply-form-${commentId}`);
                            replyForm.classList.add('d-none');
                        });
                    });

                    // Image modal handler
                    const imageModal = document.getElementById('imageModal');
                    if (imageModal) {
                        imageModal.addEventListener('show.bs.modal', function(event) {
                            const button = event.relatedTarget;
                            const imgSrc = button.getAttribute('src');
                            const modalImg = this.querySelector('.modal-body img');
                            modalImg.setAttribute('src', imgSrc);
                        });
                    }

                    // Character counter for comment textarea
                    const commentTextareas = document.querySelectorAll('textarea[name="content"]');
                    commentTextareas.forEach(textarea => {
                        const maxLength = 1000; // Set your desired max length

                        // Create and add counter element
                        const counter = document.createElement('small');
                        counter.classList.add('text-muted', 'float-end');
                        textarea.parentNode.appendChild(counter);

                        // Update counter
                        function updateCounter() {
                            const remaining = maxLength - textarea.value.length;
                            counter.textContent = `${remaining} characters remaining`;

                            if (remaining < 50) {
                                counter.classList.add('text-warning');
                            } else {
                                counter.classList.remove('text-warning');
                            }
                        }

                        textarea.addEventListener('input', updateCounter);
                        updateCounter(); // Initial count
                    });

                    // Like button animation
                    document.querySelectorAll('.btn-link .fa-heart').forEach(heart => {
                        heart.addEventListener('click', function(e) {
                            e.preventDefault();
                            this.classList.toggle('fas');
                            this.classList.toggle('far');

                            // Add pulse animation
                            this.classList.add('animate__animated', 'animate__pulse');
                            setTimeout(() => {
                                this.classList.remove('animate__animated',
                                    'animate__pulse');
                            }, 1000);
                        });
                    });

                    // Bookmark button animation
                    document.querySelectorAll('.btn-link .fa-bookmark').forEach(bookmark => {
                        bookmark.addEventListener('click', function(e) {
                            e.preventDefault();
                            this.classList.toggle('fas');
                            this.classList.toggle('far');

                            // Add bounce animation
                            this.classList.add('animate__animated', 'animate__bounce');
                            setTimeout(() => {
                                this.classList.remove('animate__animated',
                                    'animate__bounce');
                            }, 1000);
                        });
                    });

                    // Lazy loading for images
                    document.querySelectorAll('img').forEach(img => {
                        img.setAttribute('loading', 'lazy');
                    });

                    // Auto-resize textarea
                    function autoResizeTextarea(textarea) {
                        textarea.style.height = 'auto';
                        textarea.style.height = textarea.scrollHeight + 'px';
                    }

                    document.querySelectorAll('textarea').forEach(textarea => {
                        textarea.addEventListener('input', () => autoResizeTextarea(textarea));
                    });

                    // Handle mention suggestions
                    function handleMentions(textarea) {
                        textarea.addEventListener('input', function() {
                            const cursor = this.selectionStart;
                            const text = this.value.substring(0, cursor);
                            const lastWord = text.split(/\s+/).pop();

                            if (lastWord.startsWith('@') && lastWord.length > 1) {
                                // Show suggestions (implement your suggestion logic here)
                                showMentionSuggestions(lastWord.substring(1));
                            } else {
                                hideMentionSuggestions();
                            }
                        });
                    }

                    document.querySelectorAll('textarea').forEach(textarea => {
                        handleMentions(textarea);
                    });

                    // Infinite scroll for comments (if needed)
                    let page = 1;
                    let loading = false;
                    const commentsContainer = document.querySelector('.comments');

                    function loadMoreComments() {
                        if (loading) return;

                        const scrollPosition = window.innerHeight + window.scrollY;
                        const containerBottom = commentsContainer.offsetTop + commentsContainer.offsetHeight;

                        if (scrollPosition > containerBottom - 500) {
                            loading = true;

                            // Implement your AJAX call to load more comments
                            fetch(`/posts/${postId}/comments?page=${++page}`)
                                .then(response => response.json())
                                .then(data => {
                                    // Append new comments to the container
                                    appendComments(data.comments);
                                    loading = false;
                                })
                                .catch(error => {
                                    console.error('Error loading comments:', error);
                                    loading = false;
                                });
                        }
                    }

                    // Uncomment if implementing infinite scroll
                    window.addEventListener('scroll', loadMoreComments);

                    // Copy link to clipboard
                    const shareButton = document.querySelector('.dropdown-item[href="#"]');
                    if (shareButton) {
                        shareButton.addEventListener('click', function(e) {
                            e.preventDefault();

                            // Copy current URL to clipboard
                            navigator.clipboard.writeText(window.location.href)
                                .then(() => {
                                    // Show success toast
                                    const toast = new bootstrap.Toast(document.createElement(
                                        'div'));
                                    toast.show();
                                })
                                .catch(err => console.error('Failed to copy URL:', err));
                        });
                    }
                });
            }
</script>
