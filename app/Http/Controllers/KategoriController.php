<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori
     */
    public function index()
    {
        $allData = Kategori::select('nama_kategori')->get();
        $kategori = Kategori::orderBy('id', 'desc')->paginate(10);
        return view('kategori.index', compact('kategori', 'allData'));
    }

    /**
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Menyimpan data kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
            'keterangan' => 'nullable|string'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit kategori
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Mengupdate data kategori
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategori->id,
            'keterangan' => 'nullable|string'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Menghapus kategori
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
