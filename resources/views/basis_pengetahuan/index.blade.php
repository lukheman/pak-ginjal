@extends('layouts.app')

@section('title', 'Basis Pengetahuan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Basis Pengetahuan</h1>
    <p class="text-slate-500 text-sm mt-1">Pilih penyakit untuk mengelola aturan dan nilai MB/MD dari gejalanya.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($penyakit as $p)
        <a href="{{ route('basis_pengetahuan.show', $p->id) }}" class="block group">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-300 transition-all h-full flex flex-col relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-blue-500 transform origin-bottom scale-y-0 group-hover:scale-y-100 transition-transform duration-300"></div>
                
                <div class="flex items-center justify-between mb-4">
                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold rounded bg-blue-100 text-blue-700">
                        {{ $p->kode }}
                    </span>
                    <span class="text-xs font-medium text-slate-500 flex items-center bg-slate-100 px-2.5 py-1 rounded">
                        {{ $p->basis_pengetahuans_count }} Gejala
                    </span>
                </div>
                
                <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-700 transition-colors">{{ $p->nama }}</h3>
                <p class="text-sm text-slate-500 flex-1 line-clamp-2">{{ $p->deskripsi ?: 'Kelola relasi gejala untuk penyakit ini.' }}</p>
                
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center text-sm font-medium text-blue-600 group-hover:text-blue-700">
                    Kelola Aturan 
                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-10 text-center">
                <div class="mx-auto w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-1">Belum ada data penyakit</h3>
                <p class="text-slate-500 mb-4">Silakan tambahkan data penyakit terlebih dahulu melalui menu Penyakit.</p>
                <a href="{{ route('penyakit.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700">
                    Buka Menu Penyakit
                </a>
            </div>
        </div>
    @endforelse
</div>
@endsection
