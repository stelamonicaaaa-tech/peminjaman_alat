<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Peminjaman Alat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .animated-gradient {
            background: linear-gradient(-45deg, #667eea, #764ba2, #8e2de2, #4facfe);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'bx bx-hide';
            } else {
                passwordInput.type = 'password';
                icon.className = 'bx bx-show';
            }
        }
    </script>
</head>

<body class="min-h-screen animated-gradient flex items-center justify-center p-4 lg:p-8">

    <!-- Login Container -->
    <div class="w-full max-w-6xl">
        <!-- Glass Card with 2 Columns -->
        <div class="glass-card rounded-3xl shadow-2xl overflow-hidden backdrop-blur-xl">
            <div class="grid grid-cols-1 lg:grid-cols-2">

                <!-- LEFT SIDE - Image & Branding -->
                <div
                    class="hidden lg:flex flex-col items-center justify-center p-10 text-white relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-10 right-10 w-40 h-40 bg-purple-300/20 rounded-full blur-3xl"></div>

                    <!-- Content -->
                    <div class="relative z-10 text-center">
                        <!-- Animated Icon -->
                        <div class="floating mb-6 inline-block">
                            <div
                                class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-3xl flex items-center justify-center shadow-2xl border border-white/30">
                                <i class='bx bxs-shield-alt-2 text-white text-5xl'></i>
                            </div>
                        </div>

                        <!-- Title -->
                        <h2 class="text-3xl font-bold mb-3 drop-shadow-lg">
                            Sistem Peminjaman Alat
                        </h2>
                        <p class="text-base text-white/90 mb-6 max-w-md">
                            Selamat datang kembali! Login untuk mengakses sistem peminjaman alat
                        </p>

                        <!-- Features -->
                        <div class="space-y-3 text-left max-w-sm mx-auto">
                            <div
                                class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                                <div class="shrink-0 w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-check text-white text-lg'></i>
                                </div>
                                <span class="text-white/95 font-medium text-sm">Akses Mudah & Cepat</span>
                            </div>

                            <div
                                class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                                <div class="shrink-0 w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class='bx bxs-lock-alt text-white text-lg'></i>
                                </div>
                                <span class="text-white/95 font-medium text-sm">Login Terproteksi</span>
                            </div>

                            <div
                                class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                                <div class="shrink-0 w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-time text-white text-lg'></i>
                                </div>
                                <span class="text-white/95 font-medium text-sm">Tersedia 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE - Form -->
                <div class="bg-white/95 backdrop-blur-sm p-8 lg:p-10 flex flex-col justify-center">

                    <!-- Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-1">Welcome Back</h1>
                        <p class="text-gray-500 text-sm">Login untuk melanjutkan</p>
                    </div>

                    <!-- Display global auth error -->
                    @if ($errors->has('email'))
                        <div
                            class="bg-red-50 border-2 border-red-200 text-red-800 px-4 py-3 rounded-xl mb-5 flex items-start">
                            <i class='bx bxs-error-circle text-red-500 text-xl mr-3 shrink-0 mt-0.5'></i>
                            <span class="text-sm">{{ $errors->first('email') }}</span>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Email Field -->
                        <div class="@error('email') form-group-error @enderror">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative group">
                                <div class="absolute z-20 inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i
                                        class='bx bx-envelope text-gray-400 text-lg group-focus-within:text-purple-500 transition-colors'></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="glass-input w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 outline-none text-sm @error('email') border-red-400 @enderror"
                                    placeholder="your@email.com">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center">
                                    <i class='bx bxs-error-circle text-sm mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="@error('password') form-group-error @enderror">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative group">
                                <div class="absolute z-20 inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i
                                        class='bx bxs-lock-alt text-gray-400 text-lg group-focus-within:text-purple-500 transition-colors'></i>
                                </div>
                                <input type="password" id="password" name="password" required
                                    class="glass-input w-full pl-10 pr-11 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 outline-none text-sm @error('password') border-red-400 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-purple-500 transition-colors z-20">
                                    <i id="password-icon" class='bx bx-show text-lg'></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center">
                                    <i class='bx bxs-error-circle text-sm mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:from-purple-700 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 mt-2">
                            Login
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-5 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}"
                                class="font-semibold text-purple-600 hover:text-purple-700 transition duration-200 hover:underline">
                                Register here
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
