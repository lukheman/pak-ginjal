<?php

namespace App\Http\Controllers;

use App\Models\BasisPengetahuan;
use App\Models\Penyakit;
use App\Models\Gejala;
use Illuminate\Http\Request;

class BasisPengetahuanController extends Controller
{
    public function index()
    {
        $penyakit = Penyakit::orderBy('kode', 'asc')->get();
        // Load count of rules for each penyakit
        $penyakit->loadCount('basisPengetahuans');
        
        return view('basis_pengetahuan.index', compact('penyakit'));
    }

    public function show($id)
    {
        $penyakit = Penyakit::findOrFail($id);
        $basis = BasisPengetahuan::with('gejala')
            ->where('penyakit_id', $id)
            ->get();
            
        // Get gejala that are not yet added to this penyakit
        $existingGejalaIds = $basis->pluck('gejala_id')->toArray();
        $gejalaTersedia = Gejala::whereNotIn('id', $existingGejalaIds)->orderBy('kode', 'asc')->get();

        return view('basis_pengetahuan.show', compact('penyakit', 'basis', 'gejalaTersedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyakit_id' => 'required|exists:penyakit,id',
            'gejala_id' => 'required|exists:gejalas,id',
            'mb' => 'required|numeric|min:0|max:1',
            'md' => 'required|numeric|min:0|max:1',
        ]);

        // Check if rule already exists
        $exists = BasisPengetahuan::where('penyakit_id', $request->penyakit_id)
            ->where('gejala_id', $request->gejala_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Gejala tersebut sudah ada di basis pengetahuan penyakit ini.');
        }

        BasisPengetahuan::create($request->all());

        return back()->with('success', 'Aturan basis pengetahuan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $basis = BasisPengetahuan::findOrFail($id);

        $request->validate([
            'mb' => 'required|numeric|min:0|max:1',
            'md' => 'required|numeric|min:0|max:1',
        ]);

        $basis->update([
            'mb' => $request->mb,
            'md' => $request->md,
        ]);

        return back()->with('success', 'Nilai MB dan MD berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $basis = BasisPengetahuan::findOrFail($id);
        $basis->delete();

        return back()->with('success', 'Aturan basis pengetahuan berhasil dihapus.');
    }
}
