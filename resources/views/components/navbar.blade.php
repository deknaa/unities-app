<nav class="navbar bg-primary" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand">UnitiesApps</a>
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-dark">
                    Log in
                </a>

                {{-- @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="btn btn-success">
                    Register
                </a>
            @endif --}}
            @endauth
        @endif
    </div>
</nav>
