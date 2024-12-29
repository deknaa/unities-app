<section>
    <x-toast></x-toast>
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <!-- Header Section -->
                        <div class="mb-4 border-bottom pb-3">
                            <h3 class="card-title fw-bold text-primary">Profile Information</h3>
                            <p class="text-muted small">
                                Update your account's profile information.
                            </p>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <!-- Profile User Input -->
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ $user->avatar_url }}"
                                        alt="Profile photo" id="currentPhoto" class="rounded-circle object-fit-cover"
                                        style="width: 150px; height: 150px;">

                                    <div class="position-absolute bottom-0 end-0">
                                        <label class="btn btn-primary btn-sm rounded-circle"
                                            style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-camera"></i>
                                            <input type="file" name="avatar" class="d-none" accept="image/*"
                                                onchange="previewImage(this)">
                                        </label>
                                    </div>
                                </div>
                                <p class="text-muted small mt-2">Click the camera icon to change photo</p>
                            </div>

                            <!-- Full Name Input -->
                            <div class="mb-4">
                                <label for="fullname" class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control border-start-0 ps-0 @error('fullname') is-invalid @enderror"
                                        id="fullname" name="fullname" value="{{ old('fullname', $user->fullname) }}"
                                        placeholder="Enter your full name">
                                </div>
                                @error('fullname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Username Input -->
                            <div class="mb-4">
                                <label for="username" class="form-label fw-semibold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-at text-muted"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username', $user->username) }}"
                                        placeholder="Enter your username">
                                </div>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    Save Changes
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <div class="text-success small fade show">
                                        <i class="fas fa-check me-1"></i> Saved successfully!
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('currentPhoto').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</section>
