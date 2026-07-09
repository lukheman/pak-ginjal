<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'PakGinjal')) - Deteksi Dini Penyakit Ginjal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-900 selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden flex flex-col min-h-screen bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/bg-ginjal.webp') }}');">

    <!-- Dark Overlay for Readability -->
    <div class="fixed inset-0 z-[-1] bg-slate-900/60 backdrop-blur-[4px] pointer-events-none"></div>

    <!-- Navbar -->
    <header x-data="{ mobileMenuOpen: false }" class="fixed w-full top-0 z-50 glass-card transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200/50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tight text-slate-800">Pak<span class="text-blue-600">Ginjal</span></span>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-10">
                    <a href="{{ route('home') }}" class="text-base font-semibold text-slate-700 hover:text-blue-600 transition-colors">Beranda</a>
                </nav>

                <!-- Auth Buttons (Desktop) -->
                <div class="hidden md:flex items-center space-x-4">
                    @if (auth('pasien')->check())
                        <a href="{{ route('konsultasi.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Mulai Diagnosa</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 rounded-full bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition-colors shadow-lg hover:shadow-xl">
                                Keluar
                            </button>
                        </form>
                    @elseif (auth('web')->check())
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-sm font-bold hover:from-blue-600 hover:to-cyan-600 transition-all shadow-lg hover:shadow-blue-200">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-blue-600 transition-colors px-4">Masuk</a>
                        <a href="{{ route('pasien.register') }}" class="px-6 py-3 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-sm font-bold hover:from-blue-600 hover:to-cyan-600 transition-all shadow-lg shadow-blue-200/50 hover:shadow-blue-300/50 hover:-translate-y-0.5 transform">
                            Daftar Sekarang
                        </a>
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-700 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" style="display: none;" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden border-t border-slate-200 bg-white/95 backdrop-blur-xl">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50">Beranda</a>
            </div>

            <div class="pt-4 pb-4 border-t border-slate-200 px-4 space-y-3">
                @if (auth('pasien')->check())
                    <a href="{{ route('konsultasi.index') }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-full shadow-sm text-base font-semibold text-white bg-blue-600 hover:bg-blue-700">
                        Mulai Diagnosa
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="block w-full">
                        @csrf
                        <button type="submit" class="w-full text-center px-4 py-2 border border-transparent rounded-full shadow-sm text-base font-semibold text-white bg-slate-900 hover:bg-slate-800">
                            Keluar
                        </button>
                    </form>
                @elseif (auth('web')->check())
                    <a href="{{ route('dashboard') }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-full shadow-sm text-base font-semibold text-white bg-gradient-to-r from-blue-500 to-cyan-500">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-slate-300 rounded-full text-base font-semibold text-slate-700 bg-white hover:bg-slate-50">
                        Masuk
                    </a>
                    <a href="{{ route('pasien.register') }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-full shadow-sm text-base font-semibold text-white bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600">
                        Daftar Sekarang
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content (Flex-grow ensures footer sticks to bottom) -->
    <main class="flex-grow pt-28 pb-12 flex items-center justify-center">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white py-8 border-t border-slate-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl text-slate-800">Pak<span class="text-blue-600">Ginjal</span></span>
                </div>

                <p class="text-slate-500 font-medium text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} Sistem Pakar Ginjal CF & DS. Hak Cipta Dilindungi.
                </p>

            </div>
        </div>
    </footer>
</body>
</html>
