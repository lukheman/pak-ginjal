@extends('layouts.app')

@section('title', 'Dashboard Admin - SPK CF & DS')

@section('content')
<div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
    <div class="px-6 py-8 sm:p-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-blue-600 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Selamat datang, {{ Auth::user()->name }}!</h2>
        <p class="text-slate-600">Ini adalah dashboard untuk aplikasi sistem pakar dengan metode Certainty Factor & Dempster-Shafer.</p>
    </div>
</div>
@endsection
