<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakit = Penyakit::orderBy('kode', 'asc')->get();
        
        $lastPenyakit = Penyakit::orderBy('id', 'desc')->first();
        if ($lastPenyakit) {
            $lastKode = $lastPenyakit->kode;
            $number = (int) substr($lastKode, 1);
            $nextKode = 'P' . str_pad($number + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $nextKode = 'P01';
        }

        return view('penyakit.index', compact('penyakit', 'nextKode'));
    }

    public function create()
    {
        $lastPenyakit = Penyakit::orderBy('id', 'desc')->first();
        if ($lastPenyakit) {
            $lastKode = $lastPenyakit->kode;
            $number = (int) substr($lastKode, 1);
            $nextKode = 'P' . str_pad($number + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $nextKode = 'P01';
        }

        return view('penyakit.create', compact('nextKode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:penyakit,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'solusi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('penyakit_photos', 'public');
        }

        Penyakit::create($validated);

        return redirect()->route('penyakit.index')->with('success', 'Data Penyakit berhasil ditambahkan.');
    }

    public function edit(Penyakit $penyakit)
    {
        return view('penyakit.edit', compact('penyakit'));
    }

    public function update(Request $request, Penyakit $penyakit)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:penyakit,kode,' . $penyakit->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'solusi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($penyakit->photo && Storage::disk('public')->exists($penyakit->photo)) {
                Storage::disk('public')->delete($penyakit->photo);
            }
            $validated['photo'] = $request->file('photo')->store('penyakit_photos', 'public');
        }

        $penyakit->update($validated);

        return redirect()->route('penyakit.index')->with('success', 'Data Penyakit berhasil diperbarui.');
    }

    public function destroy(Penyakit $penyakit)
    {
        if ($penyakit->photo && Storage::disk('public')->exists($penyakit->photo)) {
            Storage::disk('public')->delete($penyakit->photo);
        }
        $penyakit->delete();

        return redirect()->route('penyakit.index')->with('success', 'Data Penyakit berhasil dihapus.');
    }
}
