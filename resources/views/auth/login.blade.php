@extends('layouts.guest')

@section('title', 'Login')

@section('content')

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
        <div class="px-8 pt-10 pb-8 sm:px-12">
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-blue-600 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Selamat Datang</h1>
                <p class="text-sm text-slate-500 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                @if (session('success'))
                    <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm border border-green-200 flex items-start">
                        <svg class="w-5 h-5 mr-3 shrink-0 mt-0.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif



                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500/20' }} outline-none transition-all duration-200 text-sm"
                        placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                    </div>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-500/20' }} outline-none transition-all duration-200 text-sm"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-xl shadow-sm shadow-blue-200 transition-all duration-200 focus:ring-4 focus:ring-blue-500/30">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
        <div class="bg-slate-50 border-t border-slate-100 px-8 py-4 text-center text-sm">
            <span class="text-slate-500">Belum punya akun?</span>
            <a href="{{ route('pasien.register') }}" class="font-bold text-blue-600 hover:text-blue-500 hover:underline ml-1">Daftar Pasien Baru</a>
        </div>
@endsection
