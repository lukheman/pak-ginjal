@extends('layouts.pasien')

@section('title', 'Profil Saya')

@section('content')
<div class="mb-8 text-center sm:text-left">
    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Profil Saya</h1>
    <p class="text-slate-500 mt-2 text-lg">Kelola informasi pribadi dan kredensial akun Anda.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden w-full">
    <form action="{{ route('pasien.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="p-6 md:p-8 space-y-6">
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100 flex items-start">
                    <svg class="w-5 h-5 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white font-bold text-3xl shadow-lg shadow-blue-200/50">
                    {{ substr($pasien->nama, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">{{ $pasien->nama }}</h3>
                    <p class="text-slate-500">{{ $pasien->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <!-- Nama -->
                <div class="md:col-span-2">
                    <label for="nama" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $pasien->nama) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $pasien->email) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block text-sm font-bold text-slate-700 mb-1.5">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-bold text-slate-700 mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                </div>

                <!-- Password Info -->
                <div class="md:col-span-2 pt-4 mt-2 border-t border-slate-100">
                    <h4 class="font-bold text-slate-800 mb-4">Ubah Password</h4>
                    <p class="text-sm text-slate-500 mb-4">Kosongkan kolom di bawah ini jika Anda tidak ingin mengubah password saat ini.</p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                </div>
                
                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="px-6 md:px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-sm text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
