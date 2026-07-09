@extends('layouts.app')

@section('title', 'Riwayat Diagnosis Pasien')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Diagnosis</h1>
        <p class="text-slate-500 text-sm mt-1">Menampilkan riwayat diagnosis untuk pasien: <span class="font-bold text-slate-700">{{ $pasien->nama }}</span></p>
    </div>
    
    <a href="{{ route('pasien.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm text-sm transition-all">
        <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Data Pasien
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-sm font-medium uppercase tracking-wider">
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Hasil CF</th>
                    <th class="px-6 py-4">Hasil DS</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($riwayats as $riwayat)
                    @php
                        $penyakitCf = \App\Models\Penyakit::find($riwayat->hasil_penyakit_cf_id);
                        $penyakitDs = \App\Models\Penyakit::find($riwayat->hasil_penyakit_ds_id);
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            #{{ str_pad($riwayat->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $riwayat->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($penyakitCf)
                                <div class="font-medium text-blue-700">{{ $penyakitCf->nama }}</div>
                                <div class="text-xs text-blue-500 font-semibold">{{ round($riwayat->nilai_cf * 100, 1) }}%</div>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($penyakitDs)
                                <div class="font-medium text-teal-700">{{ $penyakitDs->nama }}</div>
                                <div class="text-xs text-teal-500 font-semibold">{{ round($riwayat->nilai_ds * 100, 1) }}%</div>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('admin.riwayat.show', $riwayat->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-sm font-semibold transition-colors focus:outline-none">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Pasien ini belum memiliki riwayat diagnosis.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
