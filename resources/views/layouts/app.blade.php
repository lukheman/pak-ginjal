<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'SPK ROC-TOPSIS'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 transition-transform duration-300 bg-white border-r border-slate-200 lg:translate-x-0 lg:static lg:inset-0 flex flex-col">
            <div class="flex items-center justify-center h-16 border-b border-slate-200 px-6">
                <a href="/" class="flex items-center gap-2 font-bold text-xl text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>PakGinjal</span>
                </a>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                @auth('web')
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-700 bg-blue-50' : 'text-slate-700 hover:bg-slate-100' }} rounded-lg group">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('penyakit.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('penyakit.*') ? 'text-blue-700 bg-blue-50' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg group transition-colors">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('penyakit.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Penyakit
                    </a>

                    <a href="{{ route('gejala.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('gejala.*') ? 'text-blue-700 bg-blue-50' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg group transition-colors">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('gejala.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Gejala
                    </a>

                    <a href="{{ route('basis_pengetahuan.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('basis_pengetahuan.*') ? 'text-blue-700 bg-blue-50' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg group transition-colors">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('basis_pengetahuan.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Aturan
                    </a>

                    <a href="{{ route('pasien.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('pasien.*') ? 'text-blue-700 bg-blue-50' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg group transition-colors">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('pasien.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Pengguna (Pasien)
                    </a>
                @endauth

            </nav>

            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 w-full overflow-hidden">
            <!-- Top Header -->
            <header class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white border-b border-slate-200 lg:px-8">
                <button @click="sidebarOpen = true" class="p-2 text-slate-500 rounded-md lg:hidden hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="flex-1 flex justify-end">
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-medium text-slate-700 hidden sm:block">
                            @if(auth('pasien')->check())
                                Pasien: {{ auth('pasien')->user()->nama }}
                            @else
                                Admin: {{ Auth::user()->name ?? 'Administrator' }}
                            @endif
                        </span>
                        <div class="w-9 h-9 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-700 font-bold">
                            @if(auth('pasien')->check())
                                {{ substr(auth('pasien')->user()->nama, 0, 1) }}
                            @else
                                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-y-auto bg-slate-50/50 p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 flex items-center">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js for interactive UI components (sidebar toggle) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</body>
</html>
