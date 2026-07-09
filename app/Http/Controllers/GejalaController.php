<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index()
    {
        $gejala = Gejala::orderBy('kode', 'asc')->get();
        
        $lastGejala = Gejala::orderBy('id', 'desc')->first();
        if ($lastGejala) {
            $lastKode = $lastGejala->kode;
            $number = (int) substr($lastKode, 1);
            $nextKode = 'G' . str_pad($number + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $nextKode = 'G01';
        }

        return view('gejala.index', compact('gejala', 'nextKode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:gejalas',
            'nama' => 'required',
        ]);

        Gejala::create($request->all());

        return redirect()->route('gejala.index')->with('success', 'Data gejala berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $gejala = Gejala::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:gejalas,kode,' . $gejala->id,
            'nama' => 'required',
        ]);

        $gejala->update($request->all());

        return redirect()->route('gejala.index')->with('success', 'Data gejala berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gejala = Gejala::findOrFail($id);
        $gejala->delete();

        return redirect()->route('gejala.index')->with('success', 'Data gejala berhasil dihapus.');
    }
}
