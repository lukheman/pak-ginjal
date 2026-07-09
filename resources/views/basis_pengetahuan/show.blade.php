@extends('layouts.app')

@section('title', 'Aturan Basis Pengetahuan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="{{ route('basis_pengetahuan.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <span class="text-slate-400 text-sm">/</span>
            <span class="text-slate-500 text-sm font-medium">Aturan</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-800">Basis Pengetahuan: {{ $penyakit->nama }} ({{ $penyakit->kode }})</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola relasi gejala dan bobot kepastian (MB/MD) untuk penyakit ini.</p>
    </div>
    
    <!-- Create Modal Toggle -->
    <div x-data="{ openCreate: {{ $errors->any() && !old('_method') ? 'true' : 'false' }} }">
        <button @click="openCreate = true" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-sm text-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Aturan Gejala
        </button>

        <!-- Create Modal -->
        <template x-teleport="body">
        <div x-show="openCreate" style="display: none;" class="fixed inset-0 z-[99] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openCreate" x-transition.opacity class="fixed inset-0 bg-slate-900/50 transition-opacity" @click="openCreate = false" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="openCreate" x-transition class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form action="{{ route('basis_pengetahuan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="penyakit_id" value="{{ $penyakit->id }}">
                        
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">Tambah Gejala untuk {{ $penyakit->nama }}</h3>
                                    
                                    @if ($errors->any() && !old('_method'))
                                        <div class="mt-4 bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100 flex items-start">
                                            <svg class="w-5 h-5 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <ul class="list-disc list-inside">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mt-4 space-y-4 text-left">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Pilih Gejala <span class="text-red-500">*</span></label>
                                            @if($gejalaTersedia->isEmpty())
                                                <div class="p-3 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-sm">
                                                    Semua gejala yang ada sudah ditambahkan ke penyakit ini, atau belum ada data gejala sama sekali.
                                                </div>
                                            @else
                                                <select name="gejala_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                                                    <option value="" disabled selected>-- Pilih Gejala --</option>
                                                    @foreach($gejalaTersedia as $g)
                                                        <option value="{{ $g->id }}" {{ old('gejala_id') == $g->id ? 'selected' : '' }}>[{{ $g->kode }}] {{ $g->nama }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Measure of Belief (MB) <span class="text-red-500">*</span></label>
                                                <p class="text-xs text-slate-500 mb-2">Tingkat keyakinan pakar (0.0 - 1.0)</p>
                                                <input type="number" step="0.01" min="0" max="1" name="mb" value="{{ old('mb', '0.8') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Measure of Disbelief (MD) <span class="text-red-500">*</span></label>
                                                <p class="text-xs text-slate-500 mb-2">Tingkat ketidakyakinan (0.0 - 1.0)</p>
                                                <input type="number" step="0.01" min="0" max="1" name="md" value="{{ old('md', '0.2') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                            <button type="submit" @if($gejalaTersedia->isEmpty()) disabled @endif class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                Tambahkan
                            </button>
                            <button type="button" @click="openCreate = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-5 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </template>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-sm font-medium uppercase tracking-wider">
                    <th class="px-6 py-4 w-24">Gejala</th>
                    <th class="px-6 py-4">Nama Gejala</th>
                    <th class="px-6 py-4 text-center">MB</th>
                    <th class="px-6 py-4 text-center">MD</th>
                    <th class="px-6 py-4 text-center">CF Pakar</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($basis as $b)
                <tr x-data="{ openEdit: {{ old('_method') == 'PUT' && old('id') == $b->id ? 'true' : 'false' }}, openDelete: false }" class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">
                        {{ $b->gejala->kode }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700">
                        {{ $b->gejala->nama }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-cyan-600">
                        {{ number_format($b->mb, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-rose-600">
                        {{ number_format($b->md, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-blue-600">
                        {{ number_format($b->mb - $b->md, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <button @click="openEdit = true" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-semibold transition-colors focus:outline-none">
                                Edit Bobot
                            </button>
                            
                            <!-- Edit Modal -->
                            <template x-teleport="body">
                            <div x-show="openEdit" style="display: none;" class="fixed inset-0 z-[99] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="openEdit" x-transition.opacity class="fixed inset-0 bg-slate-900/50 transition-opacity" @click="openEdit = false" aria-hidden="true"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div x-show="openEdit" x-transition class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                        <form action="{{ route('basis_pengetahuan.update', $b->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" value="{{ $b->id }}">
                                            
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="flex items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">Edit Bobot Gejala: {{ $b->gejala->kode }}</h3>
                                                        <p class="text-sm text-slate-500 mt-1">{{ $b->gejala->nama }}</p>
                                                        
                                                        @if ($errors->any() && old('_method') == 'PUT' && old('id') == $b->id)
                                                            <div class="mt-4 bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100 flex items-start">
                                                                <svg class="w-5 h-5 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <ul class="list-disc list-inside">
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
    
                                                        <div class="mt-6 space-y-4 text-left whitespace-normal">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                                                <div>
                                                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Measure of Belief (MB) <span class="text-red-500">*</span></label>
                                                                    <input type="number" step="0.01" min="0" max="1" name="mb" value="{{ old('mb', $b->mb) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                                                                </div>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Measure of Disbelief (MD) <span class="text-red-500">*</span></label>
                                                                    <input type="number" step="0.01" min="0" max="1" name="md" value="{{ old('md', $b->md) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-slate-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                                    Simpan Perubahan
                                                </button>
                                                <button type="button" @click="openEdit = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-5 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </template>
    
                            <button @click="openDelete = true" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition-colors focus:outline-none">
                                Hapus
                            </button>
                            
                            <!-- Delete Modal -->
                            <template x-teleport="body">
                            <div x-show="openDelete" style="display: none;" class="fixed inset-0 z-[99] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="openDelete" x-transition.opacity class="fixed inset-0 bg-slate-900/50 transition-opacity" @click="openDelete = false" aria-hidden="true"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div x-show="openDelete" x-transition class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">Hapus Aturan Gejala</h3>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus data gejala <strong>{{ $b->gejala->nama }}</strong> dari aturan penyakit ini?</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-slate-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                            <form action="{{ route('basis_pengetahuan.destroy', $b->id) }}" method="POST" class="w-full sm:w-auto">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                            <button type="button" @click="openDelete = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-5 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </template>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                        Belum ada aturan gejala untuk penyakit ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
