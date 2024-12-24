<section>
    <div class="container py-5">
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
    
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')
    
                            <!-- Full Name Input -->
                            <div class="mb-4">
                                <label for="fullname" class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" 
                                        class="form-control border-start-0 ps-0 @error('fullname') is-invalid @enderror" 
                                        id="fullname" 
                                        name="fullname" 
                                        value="{{ old('fullname', $user->fullname) }}"
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
                                        id="username" 
                                        name="username" 
                                        value="{{ old('username', $user->username) }}"
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
</section>
