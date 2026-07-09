<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Pasien') - PakGinjal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col selection:bg-blue-200 selection:text-blue-900">
    
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-0 -left-[10%] w-[40%] h-[30%] rounded-full bg-blue-200/30 blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[30%] h-[40%] rounded-full bg-cyan-200/20 blur-[100px]"></div>
    </div>

    <!-- Top Navigation -->
    <nav x-data="{ mobileMenuOpen: false }" class="fixed w-full top-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200/50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <span class="font-extrabold text-2xl tracking-tight text-slate-800">Pak<span class="text-blue-600">Ginjal</span></span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('konsultasi.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('konsultasi.*') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }} text-sm font-semibold transition-colors">
                        Diagnosis Baru
                    </a>
                    <a href="{{ route('pasien.riwayat') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pasien.riwayat') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }} text-sm font-semibold transition-colors">
                        Riwayat Diagnosis
                    </a>
                    <a href="{{ route('pasien.profile') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pasien.profile') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }} text-sm font-semibold transition-colors">
                        Profil Saya
                    </a>
                </div>

                <!-- User Profile & Mobile Toggle -->
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-700">{{ auth('pasien')->user()->nama }}</span>
                        <div class="w-9 h-9 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-700 font-bold">
                            {{ substr(auth('pasien')->user()->nama, 0, 1) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-slate-500 hover:text-red-600 transition-colors">
                                Keluar
                            </button>
                        </form>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-expanded="false">
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
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden border-t border-slate-200 bg-white">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('konsultasi.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('konsultasi.*') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }} text-base font-medium">
                    Diagnosis Baru
                </a>
                <a href="{{ route('pasien.riwayat') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pasien.riwayat') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }} text-base font-medium">
                    Riwayat Diagnosis
                </a>
                <a href="{{ route('pasien.profile') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pasien.profile') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }} text-base font-medium">
                    Profil Saya
                </a>
            </div>
            <div class="pt-4 pb-3 border-t border-slate-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-700 font-bold text-lg">
                            {{ substr(auth('pasien')->user()->nama, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-bold text-slate-800">{{ auth('pasien')->user()->nama }}</div>
                        <div class="text-sm font-medium text-slate-500">{{ auth('pasien')->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-100">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-12">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-cyan-50 text-cyan-700 border border-cyan-200 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <p class="text-sm text-slate-500">
                &copy; {{ date('Y') }} PakGinjal. Sistem Pakar Penyakit Ginjal.
            </p>
        </div>
    </footer>
</body>
</html>
