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
        <h1>Manage User</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Join Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $user->avatar_url }}" alt="Profile photo"
                                class="rounded-circle object-fit-cover" style="width: 50px; height: 50px;">
                            {{ $user->fullname }}
                        </td>
                        <td>{{ Str::limit($user->username, 20, '...') }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this account?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-success text-white" data-bs-toggle="modal"
                                data-bs-target="#userDetailModal-{{ $user->id }}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal for Post Details -->
                    <div class="modal fade" id="userDetailModal-{{ $user->id }}" tabindex="-1"
                        aria-labelledby="postDetailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="postDetailModalLabel">Users Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Post Details -->
                                    <div class="d-flex align-items-start mb-3">
                                        <!-- Author Avatar -->
                                        <img src="{{ $user->avatar_url }}" alt="Profile photo"
                                            class="rounded-circle me-3"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ $user->fullname }}</h6>
                                            <small class="text-muted"><span>@</span>{{ $user->username }}</small>
                                            <small
                                                class="text-muted d-block">{{ $user->created_at->format('d M Y, H:i') }}</small>
                                        </div>
                                    </div>
                                    <hr>

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
        {{ $users->links() }}
    </div>
</x-app-layout>