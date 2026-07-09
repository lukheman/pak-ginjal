@extends('layouts.pasien')

@section('title', 'Riwayat Diagnosis')

@section('content')
<div class="mb-8 text-center sm:text-left">
    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Diagnosis</h1>
    <p class="text-slate-500 mt-2 text-lg">Pantau riwayat hasil skrining kesehatan ginjal Anda.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    @if(count($riwayats) > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-sm font-bold uppercase tracking-wider">
                    <th class="px-6 py-4">Tanggal Konsultasi</th>
                    <th class="px-6 py-4">Metode CF</th>
                    <th class="px-6 py-4">Metode DS</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($riwayats as $riwayat)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-900">{{ $riwayat->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-slate-500">{{ $riwayat->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            @php
                                $penyakitCf = \App\Models\Penyakit::find($riwayat->hasil_penyakit_cf_id);
                            @endphp
                            <span class="text-sm font-bold text-blue-700">{{ $penyakitCf ? $penyakitCf->nama : 'Tidak terdeteksi' }}</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 inline-block w-max mt-1">
                                Akurasi: {{ round($riwayat->nilai_cf * 100, 2) }}%
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            @php
                                $penyakitDs = \App\Models\Penyakit::find($riwayat->hasil_penyakit_ds_id);
                            @endphp
                            <span class="text-sm font-bold text-cyan-700">{{ $penyakitDs ? $penyakitDs->nama : 'Tidak terdeteksi' }}</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-cyan-50 text-cyan-600 inline-block w-max mt-1">
                                Akurasi: {{ round($riwayat->nilai_ds * 100, 2) }}%
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('konsultasi.hasil', $riwayat->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm font-semibold transition-all">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-12 text-center flex flex-col items-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-900 mb-2">Belum ada riwayat diagnosis</h3>
        <p class="text-slate-500 mb-6">Mulai skrining ginjal Anda sekarang untuk mengetahui kondisi kesehatan Anda.</p>
        <a href="{{ route('konsultasi.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-sm text-sm">
            Mulai Diagnosis
        </a>
    </div>
    @endif
</div>
@endsection
