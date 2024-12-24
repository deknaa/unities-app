<style>
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

    .btn-register {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.8rem;
    }

    .btn-register:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: all 0.2s;
    }
</style>
<x-guest-layout>
    <div class="container">
        <div class="form-container mx-auto">
            <h2 class="text-center mb-4">Daftar Akun</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Fullname -->
                <div class="form-floating">
                    <input type="text" class="form-control" id="fullname" placeholder="Full Name" name="fullname"
                        required autocomplete="fullname">
                    <label for="fullname">Full Name</label>
                    <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                </div>

                {{-- Username --}}
                <div class="form-floating">
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                        required autocomplete="username">
                    <label for="username">Username</label>
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" placeholder="name@example.com"
                        name="email" required autocomplete="email">
                    <label for="email">Email address</label>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password"
                        required autocomplete="new-password">
                    <label for="password">Password</label>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="form-floating">
                    <input type="password" class="form-control" id="password_confirmation"
                        placeholder="Konfirmasi Password" name="password_confirmation" required
                        autocomplete="new-password">
                    <label for="password_confirmation">Password</label>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="text-center mt-4">
                    <button class="w-100 btn btn-lg btn-primary btn-register mb-3" type="submit">
                        Register
                    </button>

                    <p class="mb-0">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
