<x-guest-layout>
    <div class="container">
        <div class="form-container mx-auto">
            <h2 class="text-center mb-4">Login</h2>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username -->
                <div class="form-floating">
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" required autofocus autocomplete="username">
                    <label for="username">Username</label>
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-floating mt-3">
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required autocomplete="current-password">
                    <label for="password">Password</label>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button class="w-100 btn btn-lg btn-primary btn-login mt-4" type="submit">
                    {{ __('Log in') }}
                </button>

                <!-- Google Login -->
                <div class="text-center mt-3">
                    <p class="text-muted">Or login with</p>
                    <a href="{{ route('google.login') }}" class="btn btn-outline-dark btn-lg w-100">
                        <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" alt="Google" width="20" height="20" class="me-2">
                        Continue with Google
                    </a>
                </div>

                <!-- Register Link -->
                <p class="mt-3 text-center">
                    Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none">Register here</a>
                </p>
            </form>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.8rem;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            transition: all 0.2s;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        a {
            color: #667eea;
        }

        a:hover {
            color: #764ba2;
        }
    </style>
</x-guest-layout>