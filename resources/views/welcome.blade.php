<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistem Pakar') }} - Deteksi Dini Penyakit Ginjal</title>

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
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden">

    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-200/40 blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-cyan-200/30 blur-[100px]"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[60%] h-[60%] rounded-full bg-indigo-100/40 blur-[150px]"></div>
    </div>

    <!-- Navbar -->
    <header x-data="{ mobileMenuOpen: false }" class="fixed w-full top-0 z-50 glass-card transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200/50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tight text-slate-800">Pak<span class="text-blue-600">Ginjal</span></span>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-10">
                    <a href="#beranda" class="text-base font-semibold text-slate-700 hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="#penyakit" class="text-base font-semibold text-slate-700 hover:text-blue-600 transition-colors">Penyakit Ginjal</a>
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
                <a href="#beranda" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50">Beranda</a>
                <a href="#penyakit" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50">Penyakit Ginjal</a>
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

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-40 pb-24 lg:pt-52 lg:pb-36 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/bg-ginjal.webp') }}');">
        <!-- Dark Overlay for Readability -->
        <div class="absolute inset-0 bg-slate-900/75 sm:bg-slate-900/60 bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-slate-900/90"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold tracking-tighter text-white mb-8 leading-[1.1]">
                Sayangi Ginjal Anda, <br class="hidden md:block"/>
                <span class="bg-gradient-to-r from-blue-400 to-cyan-400 text-gradient">Deteksi Sejak Dini.</span>
            </h1>

            <p class="mt-6 max-w-2xl text-lg md:text-2xl text-slate-200 mx-auto mb-12 leading-relaxed font-medium">
                Pahami gejala dan deteksi potensi penyakit ginjal secara akurat menggunakan keandalan sistem pakar berbasis kecerdasan buatan.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-5">
                @if (auth('pasien')->check())
                    <a href="{{ route('konsultasi.index') }}" class="w-full sm:w-auto px-10 py-4 rounded-full bg-blue-600 text-white font-bold text-lg hover:bg-blue-500 transition-all shadow-xl shadow-blue-900/50 hover:shadow-2xl hover:-translate-y-1 flex items-center justify-center group">
                        Mulai Konsultasi
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @elseif (auth('web')->check())
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-10 py-4 rounded-full bg-blue-600 text-white font-bold text-lg hover:bg-blue-500 transition-all shadow-xl shadow-blue-900/50 hover:shadow-2xl hover:-translate-y-1 flex items-center justify-center group">
                        Buka Dashboard
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @else
                    <a href="{{ route('pasien.register') }}" class="w-full sm:w-auto px-10 py-4 rounded-full bg-blue-600 text-white font-bold text-lg hover:bg-blue-500 transition-all shadow-xl shadow-blue-900/50 hover:shadow-2xl hover:-translate-y-1 flex items-center justify-center group">
                        Cek Gejala Sekarang
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="#penyakit" class="w-full sm:w-auto px-10 py-4 rounded-full bg-white/10 backdrop-blur-md text-white border-2 border-white/20 font-bold text-lg hover:bg-white/20 hover:border-white/40 transition-all shadow-sm hover:shadow-md flex items-center justify-center">
                        Informasi Penyakit
                    </a>
                @endif
            </div>

        </div>
    </section>

    <!-- Penyakit Information Section -->
    <section id="penyakit" class="py-24 bg-slate-50 relative overflow-hidden">
        <div class="absolute inset-y-0 right-0 w-1/2 bg-blue-100/30 rounded-l-full blur-3xl -z-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-blue-600 font-bold tracking-wide uppercase mb-3">Ensiklopedia Kesehatan</h2>
                <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6">Mengenal Jenis Penyakit Ginjal</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($penyakits as $penyakit)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col h-full group">
                        <div class="h-56 bg-slate-100 relative overflow-hidden">
                            @if($penyakit->photo)
                                <img src="{{ asset('storage/' . $penyakit->photo) }}" alt="{{ $penyakit->nama }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-100 to-cyan-50 flex items-center justify-center transition-transform duration-700 group-hover:scale-110">
                                    <svg class="w-16 h-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-extrabold text-blue-600 shadow-sm border border-blue-100">
                                {{ $penyakit->kode }}
                            </div>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <h4 class="text-2xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $penyakit->nama }}</h4>
                            <div class="text-slate-600 text-base mb-6 line-clamp-3 leading-relaxed flex-1">
                                {!! strip_tags($penyakit->deskripsi) !!}
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <button onclick="document.getElementById('modal-{{ $penyakit->id }}').classList.remove('hidden')" class="text-blue-600 font-bold hover:text-blue-700 inline-flex items-center transition-colors">
                                    Lihat Penanganan
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Penyakit -->
                    <div id="modal-{{ $penyakit->id }}" class="hidden fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <!-- Background overlay -->
                            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-{{ $penyakit->id }}').classList.add('hidden')"></div>

                            <!-- Modal panel -->
                            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-6">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">{{ $penyakit->kode }}</div>
                                            <h3 class="text-2xl leading-6 font-extrabold text-slate-900" id="modal-title">
                                                {{ $penyakit->nama }}
                                            </h3>
                                        </div>
                                        <button type="button" class="text-slate-400 hover:text-slate-500 bg-slate-50 rounded-full p-2 transition-colors" onclick="document.getElementById('modal-{{ $penyakit->id }}').classList.add('hidden')">
                                            <span class="sr-only">Tutup</span>
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-4">
                                        @if($penyakit->photo)
                                            <img src="{{ asset('storage/' . $penyakit->photo) }}" alt="{{ $penyakit->nama }}" class="w-full h-64 object-cover rounded-2xl mb-6 shadow-inner">
                                        @endif
                                        <div class="mb-6">
                                            <h4 class="text-lg font-bold text-slate-900 mb-2 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Deskripsi Kondisi
                                            </h4>
                                            <div class="text-slate-600 prose prose-slate">
                                                {!! $penyakit->deskripsi !!}
                                            </div>
                                        </div>
                                        <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                                            <h4 class="text-lg font-bold text-blue-900 mb-2 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Rekomendasi Penanganan Medis
                                            </h4>
                                            <div class="text-blue-800 prose prose-blue">
                                                {!! $penyakit->solusi !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-slate-50 px-4 py-4 sm:px-8 flex flex-row-reverse rounded-b-3xl">
                                    <button type="button" class="w-full inline-flex justify-center rounded-full border border-transparent shadow-sm px-6 py-2.5 bg-slate-900 text-base font-bold text-white hover:bg-slate-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors" onclick="document.getElementById('modal-{{ $penyakit->id }}').classList.add('hidden')">
                                        Kembali
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-dashed border-slate-300">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-2">Belum ada data rekam medis penyakit</h4>
                        <p class="text-slate-500 font-medium">Data penyakit ginjal akan segera diverifikasi oleh pakar kesehatan kami.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl text-slate-800">Pak<span class="text-blue-600">Ginjal</span></span>
                </div>

                <p class="text-slate-500 font-medium text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} Sistem Pakar Ginjal CF & DS. Hak Cipta Dilindungi. Disclaimer: Ini bukan pengganti vonis dokter sungguhan.
                </p>

            </div>
        </div>
    </footer>
</body>
</html>
