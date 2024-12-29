<x-app-layout>
    <x-navbar></x-navbar>

    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <!-- Create Post Card -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="mb-4 fw-bold">Buat Postingan Baru</h5>
                        <!-- Header -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="position-relative me-3">
                                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                    class="rounded-circle border"
                                    alt="Profile"
                                    style="width: 48px; height: 48px; object-fit: cover;">
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ auth()->user()->fullname }}</h6>
                                <small class="text-muted"><span>@</span>{{ auth()->user()->username }}</small>
                            </div>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="createPostForm">
                            @csrf
                            
                            <!-- Content Input -->
                            <div class="mb-4">
                                <textarea class="form-control border-0 bg-light"
                                    id="content"
                                    name="content"
                                    rows="4"
                                    placeholder="Apa yang sedang Anda pikirkan?"
                                    style="resize: none;"
                                    required></textarea>
                                <div class="small text-end texwt-muted mt-2">
                                    <span id="charCount">0</span> karakter
                                </div>
                            </div>

                            <!-- Media Upload Preview -->
                            <div class="mb-4 d-none" id="uploadPreview">
                                <div class="position-relative">
                                    <!-- Image Preview -->
                                    <img src="" alt="Preview" class="img-fluid rounded-3 w-100 d-none" id="imagePreview" style="max-height: 300px; object-fit: cover;">
                                    <!-- Video Preview -->
                                    <video controls class="w-100 rounded-3 d-none" id="videoPreviewUpload">
                                        <source src="" type="">
                                    </video>
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" id="removeMedia">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                <div class="d-flex gap-2">
                                    <!-- Media Upload Button -->
                                    <div class="position-relative">
                                        <input type="file"
                                            class="position-absolute top-0 start-0 opacity-0"
                                            id="media"
                                            name="media"
                                            accept="image/*,video/*"
                                            style="width: 1px; height: 1px;">
                                        <button type="button" 
                                                class="btn btn-light rounded-pill"
                                                onclick="document.getElementById('media').click()">
                                            <i class="fas fa-image me-2"></i>
                                            Tambah Media
                                        </button>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" 
                                        class="btn btn-primary rounded-pill px-4" 
                                        id="submitButton" 
                                        disabled>
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Posting
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card border-0 shadow-sm rounded-3 mt-4 preview-card d-none">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-eye me-2 text-primary"></i>
                            <h6 class="mb-0 text-primary">Preview Postingan</h6>
                        </div>
                        
                        <!-- Preview Content Container -->
                        <div class="preview-container">
                            <!-- Text Content Preview -->
                            <div class="preview-content mb-3"></div>
                            
                            <!-- Media Preview -->
                            <div class="preview-media d-none">
                                <!-- Preview Image -->
                                <img src="" alt="Preview" class="img-fluid rounded-3 w-100 d-none" id="previewImage" style="max-height: 300px; object-fit: cover;">
                                <!-- Preview Video -->
                                <video controls class="w-100 rounded-3 d-none" id="previewVideo">
                                    <source src="" type="">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .preview-card {
            transition: all 0.3s ease;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .preview-media img,
        .preview-media video {
            transition: all 0.3s ease;
        }

        .preview-media:hover img,
        .preview-media:hover video {
            transform: scale(1.01);
        }

        /* Custom scrollbar */
        textarea::-webkit-scrollbar {
            width: 8px;
        }

        textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .preview-container {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('createPostForm');
            const content = document.getElementById('content');
            const mediaInput = document.getElementById('media');
            const uploadPreview = document.getElementById('uploadPreview');
            const imagePreview = document.getElementById('imagePreview');
            const videoPreviewUpload = document.getElementById('videoPreviewUpload');
            const charCount = document.getElementById('charCount');
            const submitButton = document.getElementById('submitButton');
            const removeMedia = document.getElementById('removeMedia');
            const previewCard = document.querySelector('.preview-card');
            const previewContent = document.querySelector('.preview-content');
            const previewMedia = document.querySelector('.preview-media');
            const previewImage = document.getElementById('previewImage');
            const previewVideo = document.getElementById('previewVideo');

            let currentMediaType = null;
            let currentMediaUrl = null;

            // Character counter and content preview
            content.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length;
                submitButton.disabled = length === 0;
                updatePreview();
            });

            // Media preview
            mediaInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                    if (file.type.startsWith('image/')) {
                        currentMediaType = 'image';
                        reader.onload = function(e) {
                            // Update upload preview
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('d-none');
                            videoPreviewUpload.classList.add('d-none');
                            uploadPreview.classList.remove('d-none');

                            // Update content preview
                            currentMediaUrl = e.target.result;
                            updatePreview();
                        }
                    } else if (file.type.startsWith('video/')) {
                        currentMediaType = 'video';
                        reader.onload = function(e) {
                            // Update upload preview
                            videoPreviewUpload.src = e.target.result;
                            videoPreviewUpload.type = file.type;
                            videoPreviewUpload.classList.remove('d-none');
                            imagePreview.classList.add('d-none');
                            uploadPreview.classList.remove('d-none');

                            // Update content preview
                            currentMediaUrl = e.target.result;
                            updatePreview();
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Remove media
            removeMedia.addEventListener('click', function() {
                mediaInput.value = '';
                uploadPreview.classList.add('d-none');
                currentMediaType = null;
                currentMediaUrl = null;
                updatePreview();
            });

            // Preview update
            function updatePreview() {
                const hasContent = content.value.trim();
                const hasMedia = currentMediaUrl != null;

                if (hasContent || hasMedia) {
                    previewCard.classList.remove('d-none');
                    
                    // Update text content
                    previewContent.innerHTML = content.value
                        .replace(/\n/g, '<br>')
                        .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" class="text-primary text-decoration-none">$1</a>');

                    // Update media preview
                    if (hasMedia) {
                        previewMedia.classList.remove('d-none');
                        if (currentMediaType === 'image') {
                            previewImage.src = currentMediaUrl;
                            previewImage.classList.remove('d-none');
                            previewVideo.classList.add('d-none');
                        } else if (currentMediaType === 'video') {
                            previewVideo.src = currentMediaUrl;
                            previewVideo.classList.remove('d-none');
                            previewImage.classList.add('d-none');
                        }
                    } else {
                        previewMedia.classList.add('d-none');
                    }
                } else {
                    previewCard.classList.add('d-none');
                }
            }

            // Form submission animation
            form.addEventListener('submit', function() {
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2"></span>
                    Memposting...
                `;
            });
        });
    </script>
</x-app-layout>