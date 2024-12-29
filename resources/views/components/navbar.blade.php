<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <span class="brand-text">UnitiesApps</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Search Form - Visible on larger screens -->
            <form class="d-none d-lg-flex mx-lg-4 flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-white nav-link">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="search" class="form-control bg-transparent border-start-0" placeholder="Search..."
                        aria-label="Search">
                </div>
            </form>

            <!-- Authentication Links -->
            @if (Route::has('login'))
                @auth
                    <div class="navbar-nav align-items-center gap-2">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="fas fa-chart-line me-2"></i>Dashboard
                            </a>
                            <a href="{{ route('posts.manage') }}" class="nav-link">
                                <i class="fas fa-tasks me-2"></i>Manage Post
                            </a>
                            <a href="{{ route('users.manage') }}" class="nav-link">
                                <i class="fas fa-users-cog me-2"></i>Users Manage
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline nav-item">
                                @csrf
                                <button type="submit" class="btn btn-glass">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        @elseif(Auth::user()->role == 'user')
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="fas fa-home me-2"></i>Home
                            </a>
                            <a href="{{ route('profile.edit') }}" class="nav-link">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                            <a href="{{ route('posts.create') }}" class="nav-link">
                                <i class="fas fa-plus-circle me-2"></i>Post
                            </a>
                            <a href="{{ route('bookmarks.index') }}" class="nav-link">
                                <i class="fas fa-bookmark me-2"></i>Bookmark
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline nav-item">
                                @csrf
                                <button type="submit" class="btn btn-glass">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-glass">
                        <i class="fas fa-sign-in-alt me-2"></i>Log in
                    </a>
                @endauth
            @endif
        </div>
    </div>
</nav>

<style>
    /* Navbar Styles */
    .navbar {
        background: linear-gradient(to right, #0d37f1, #2152f5);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 1rem 0;
        transition: all 0.3s ease;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    /* Brand Styles */
    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
    }

    .brand-text {
        background: linear-gradient(45deg, #00f2fe, #4facfe);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Navigation Links */
    .nav-link {
        color: rgb(255, 255, 255) !important;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        position: relative;
    }

    .nav-link:hover {
        color: rgb(7, 69, 238) !important;
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-1px);
    }

    /* Search Input Styling */
    .input-group {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2rem;
        overflow: hidden;
    }

    .input-group-text,
    .form-control {
        border-color: transparent;
    }

    .form-control {
        color: white !important;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-control:focus {
        background-color: transparent;
        box-shadow: none;
        border-color: transparent;
    }

    /* Glass Button Effect */
    .btn-glass {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgb(255, 255, 255);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        transition: all 0.3s ease;
    }

    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.9);
        color: rgb(7, 134, 238);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Scrolled State Styles */
    .navbar.scrolled {
        background: linear-gradient(to right, rgba(255, 255, 255, 0.7), rgba(236, 241, 255, 0.7));
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
    }

    .navbar.scrolled .nav-link {
        color: #0d37f1 !important;
    }

    .navbar.scrolled .nav-link:hover {
        background: rgba(13, 55, 241, 0.1);
        color: #0d37f1 !important;
    }

    .navbar.scrolled .btn-glass {
        background: rgba(13, 55, 241, 0.1);
        color: #0d37f1;
    }

    .navbar.scrolled .btn-glass:hover {
        background: rgba(13, 55, 241, 0.2);
    }

    .navbar.scrolled .brand-text {
        background: linear-gradient(45deg, #0d37f1, #2152f5);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .navbar.scrolled .form-control::placeholder {
        color: #0d37f1 !important;
    }

    /* Mobile Responsiveness */
    @media (max-width: 991.98px) {
        .navbar {
            padding: 0.5rem 1rem;
        }

        .navbar-collapse {
            background: linear-gradient(to bottom, #0d37f1, #2152f5);
            margin: 0 -1rem;
            padding: 1rem;
            border-radius: 0 0 1rem 1rem;
            max-height: calc(100vh - 70px);
            overflow-y: auto;
        }

        .navbar-nav {
            padding: 1rem 0;
        }

        .nav-link {
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            text-align: center;
        }

        .navbar-toggler {
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler i {
            color: white;
            font-size: 1.5rem;
        }

        .btn-glass {
            width: 100%;
            margin: 0.5rem 0;
            text-align: center;
        }

        /* Scrolled state in mobile */
        .navbar.scrolled .navbar-collapse {
            background: white;
        }

        .navbar.scrolled .navbar-toggler i {
            color: #0d37f1;
        }
    }

    /* Active Link Indicator */
    .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
    }

    .navbar.scrolled .nav-link.active {
        background: rgba(13, 55, 241, 0.1);
    }

    /* Icon Animation */
    .nav-link i {
        transition: transform 0.3s ease;
    }

    .nav-link:hover i {
        transform: translateX(2px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar');
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        // Scroll Effect
        function handleScroll() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Initialize on load

        // Mobile Menu Toggle
        if (navbarToggler && navbarCollapse) {
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInside = navbar.contains(event.target);

                if (!isClickInside && navbarCollapse.classList.contains('show')) {
                    navbarToggler.click();
                }
            });

            // Close menu when clicking on a link
            const navLinks = navbarCollapse.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (navbarCollapse.classList.contains('show')) {
                        navbarToggler.click();
                    }
                });
            });

            // Update toggler icon based on collapse state
            navbarCollapse.addEventListener('show.bs.collapse', function() {
                navbarToggler.innerHTML = '<i class="fas fa-times"></i>';
            });

            navbarCollapse.addEventListener('hide.bs.collapse', function() {
                navbarToggler.innerHTML = '<i class="fas fa-bars"></i>';
            });
        }

        // Active Link Handler
        const currentLocation = window.location.href;
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            if (link.href === currentLocation) {
                link.classList.add('active');
            }
        });
    });
</script>
