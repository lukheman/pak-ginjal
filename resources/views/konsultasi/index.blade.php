@extends('layouts.pasien')

@section('title', 'Mulai Konsultasi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Konsultasi / Diagnosa Penyakit</h1>
    <p class="text-slate-500 text-sm mt-1">Isi data diri dan pilih gejala yang Anda alami beserta tingkat keyakinannya.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <form action="{{ route('konsultasi.proses') }}" method="POST">
        @csrf
        


        <!-- Daftar Gejala -->
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Pilih Gejala yang Dialami
                </h2>
                <span class="text-sm text-slate-500">Pilih tingkat keyakinan (CF User) pada gejala yang dialami. Biarkan kosong jika tidak mengalami.</span>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-sm font-medium uppercase tracking-wider">
                            <th class="px-4 py-3 w-20 text-center">Kode</th>
                            <th class="px-4 py-3">Nama Gejala</th>
                            <th class="px-4 py-3 w-64 text-center">Tingkat Keyakinan Anda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($gejala as $g)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-900 text-center">
                                {{ $g->kode }}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $g->nama }}
                            </td>
                            <td class="px-4 py-3">
                                <select name="gejala[{{ $g->id }}]" class="w-full text-sm px-3 py-2 rounded border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                                    <option value="">-- Pilih Kondisi --</option>
                                    <option value="1.0">Sangat Yakin / Pasti</option>
                                    <option value="0.8">Yakin / Hampir Pasti</option>
                                    <option value="0.6">Cukup Yakin</option>
                                    <option value="0.4">Sedikit Yakin / Ragu</option>
                                    <option value="0.2">Sangat Ragu</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-sm text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Proses Diagnosa
            </button>
        </div>
    </form>
</div>
@endsection
