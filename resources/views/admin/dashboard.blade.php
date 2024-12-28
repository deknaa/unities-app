<x-app-layout>
    <x-navbar></x-navbar>
    {{-- Dashboard --}}
    <div class="container py-4">
        {{-- Total Users --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fa-solid fa-users text-primary fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small">Total Users</div>
                                <div class="fs-5 fw-semibold">{{ $totalUsers }}</div>
                                <div class="text-success small">
                                    <i class="bi bi-arrow-up"></i> 12% increase
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Posts --}}
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded">
                                <i class="fa-solid fa-rss text-success fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small">Total Posts</div>
                                <div class="fs-5 fw-semibold">{{ $totalPosts }}</div>
                                <div class="text-success small">
                                    <i class="bi bi-arrow-up"></i> 8% increase
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
            {{-- New Users --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">New Users</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach ($newUsers as $user)
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->avatar_url }}" class="rounded-circle me-3" width="40"
                                            height="40">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $user->fullname }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</x-app-layout>
