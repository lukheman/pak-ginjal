<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource (manajemen pengguna).
     */
    public function index()
    {
        $penggunas = Admin::latest()->get();
        return view('pengguna.index', compact('penggunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('pengguna.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin,email',
            'password' => 'required|string|min:6|confirmed',
            'tanggal_lahir' => 'nullable|date',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Data Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $pengguna)
    {
        return redirect()->route('pengguna.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $pengguna)
    {
        return redirect()->route('pengguna.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $pengguna)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('admin', 'email')->ignore($pengguna->id),
            ],
            'tanggal_lahir' => 'nullable|date',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        // Segarkan user yang di-cache di guard bila admin mengubah akunnya sendiri,
        // agar nama di navbar langsung mengikuti data terbaru
        if (auth()->id() === $pengguna->id) {
            auth()->setUser($pengguna->fresh());
        }

        return redirect()->route('pengguna.index')->with('success', 'Data Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $pengguna)
    {
        // Cegah admin menghapus akunnya sendiri yang sedang login
        if (auth()->id() === $pengguna->id) {
            return redirect()->route('pengguna.index')->with('error', 'Tidak dapat menghapus akun sendiri yang sedang login.');
        }

        // Cegah menghapus satu-satunya pengguna yang tersisa
        if (Admin::count() <= 1) {
            return redirect()->route('pengguna.index')->with('error', 'Tidak dapat menghapus. Minimal harus ada satu pengguna.');
        }

        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('success', 'Data Pengguna berhasil dihapus.');
    }
}
