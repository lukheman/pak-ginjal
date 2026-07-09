@extends('layouts.app')

@section('title', 'Detail Riwayat Diagnosis')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Detail Diagnosis</h1>
        <p class="text-slate-500 text-sm mt-1">Pasien: <span class="font-bold text-slate-700">{{ $riwayat->nama_pasien }}</span> | Tanggal: {{ $riwayat->created_at->format('d M Y, H:i') }}</p>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.riwayat.index', $riwayat->pasien_id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm text-sm transition-all">
            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Gejala -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-4 py-3 border-b border-slate-200">
                <h3 class="text-slate-800 font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Gejala yang Dialami
                </h3>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-slate-100">
                    @php
                        function getKondisiAdminText($value) {
                            $val = floatval($value);
                            if ($val >= 1.0) return 'Sangat Yakin / Pasti';
                            if ($val >= 0.8) return 'Yakin / Hampir Pasti';
                            if ($val >= 0.6) return 'Cukup Yakin';
                            if ($val >= 0.4) return 'Sedikit Yakin / Ragu';
                            return 'Sangat Ragu';
                        }
                    @endphp
                    @foreach($gejalaList as $g)
                    <li class="px-4 py-3 hover:bg-slate-50 flex items-start">
                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold rounded bg-slate-100 text-slate-600 mr-3 mt-0.5">
                            {{ $g->kode }}
                        </span>
                        <div>
                            <p class="text-sm font-medium text-slate-800">{{ $g->nama }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">Input: <span class="font-semibold text-blue-600">{{ getKondisiAdminText($gejalaUser[$g->id]) }} ({{ $gejalaUser[$g->id] }})</span></p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Hasil -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Hasil Certainty Factor -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-blue-50/50">
                <h2 class="text-xl font-bold text-slate-800">Hasil Metode Certainty Factor (CF)</h2>
            </div>
            
            <div class="p-8 flex flex-col items-center justify-center text-center">
                @if($penyakitCf)
                    <div class="relative w-32 h-32 mb-6">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-slate-100" stroke-width="3"></circle>
                            @php 
                                $percentageCf = round($riwayat->nilai_cf * 100, 2); 
                            @endphp
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-600" stroke-width="3" stroke-dasharray="{{ $percentageCf }}, 100" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-black text-slate-800">{{ $percentageCf }}%</span>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-black text-blue-700 mb-2">{{ $penyakitCf->nama }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 mb-6">
                        Kode: {{ $penyakitCf->kode }}
                    </span>
                    
                    <div class="w-full text-left bg-slate-50 p-4 rounded-xl border border-slate-200 mb-4">
                        <h4 class="font-bold text-slate-800 mb-1">Deskripsi</h4>
                        <p class="text-sm text-slate-600">{{ $penyakitCf->deskripsi ?: '-' }}</p>
                    </div>

                    <div class="w-full text-left bg-cyan-50 p-4 rounded-xl border border-cyan-200">
                        <h4 class="font-bold text-cyan-800 mb-1">Solusi / Penanganan</h4>
                        <p class="text-sm text-cyan-700">{{ $penyakitCf->solusi ?: '-' }}</p>
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-slate-500">Penyakit tidak terdeteksi (0%).</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Hasil Dempster-Shafer -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-teal-50/50">
                <h2 class="text-xl font-bold text-slate-800">Hasil Metode Dempster-Shafer (DS)</h2>
            </div>
            
            <div class="p-8 flex flex-col items-center justify-center text-center">
                @if($penyakitDs)
                    <div class="relative w-32 h-32 mb-6">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-slate-100" stroke-width="3"></circle>
                            @php 
                                $percentageDs = round($riwayat->nilai_ds * 100, 2); 
                            @endphp
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-teal-500" stroke-width="3" stroke-dasharray="{{ $percentageDs }}, 100" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-black text-slate-800">{{ $percentageDs }}%</span>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-black text-teal-700 mb-2">{{ $penyakitDs->nama }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-teal-100 text-teal-800 mb-6">
                        Kode: {{ $penyakitDs->kode }}
                    </span>

                    <div class="w-full text-left bg-slate-50 p-4 rounded-xl border border-slate-200 mb-4">
                        <h4 class="font-bold text-slate-800 mb-1">Deskripsi</h4>
                        <p class="text-sm text-slate-600">{{ $penyakitDs->deskripsi ?: '-' }}</p>
                    </div>

                    <div class="w-full text-left bg-cyan-50 p-4 rounded-xl border border-cyan-200">
                        <h4 class="font-bold text-cyan-800 mb-1">Solusi / Penanganan</h4>
                        <p class="text-sm text-cyan-700">{{ $penyakitDs->solusi ?: '-' }}</p>
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-slate-500">Penyakit tidak terdeteksi (0%).</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
