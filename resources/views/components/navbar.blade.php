<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/">UnitiesApps</a>
        
        <!-- Hamburger button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation items -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            @if (Route::has('login'))
                @auth
                <div class="navbar-nav align-items-center gap-2">
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                        <a href="{{ route('login') }}" class="nav-link">Manage Post</a>
                        <a href="{{ route('login') }}" class="nav-link">Total Pengguna</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    @elseif(Auth::user()->role == 'user')
                        <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="nav-link">Profile</a>
                        <a href="{{ route('login') }}" class="nav-link">Post</a>
                        <a href="{{ route('login') }}" class="nav-link">Bookmark</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Log in</a>
                    @endif
                </div>
                @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Log in</a>
                @endauth
            @endif
        </div>
    </div>
</nav>