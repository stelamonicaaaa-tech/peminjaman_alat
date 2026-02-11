<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Menampilkan daftar alat
     */
    public function index()
    {
        $allData = Alat::get();

        $alat = Alat::with('kategori')
            ->orderBy('id', 'desc')
            ->paginate(perPage: 5);

        return view('alat.index', compact('alat', 'allData'));
    }

    /**
     * Menampilkan form tambah alat
     */
    public function create()
    {
        $kategori = Kategori::select('id', 'nama_kategori')
            ->orderBy('nama_kategori', 'asc')
            ->get();
        return view('alat.create', compact('kategori'));
    }

    /**
     * Menyimpan data alat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_alat'   => 'required|string|max:50|unique:alat,kode_alat',
            'nama_alat'   => 'required|string|max:150',
            'kategori_id' => 'required|exists:kategori,id',
            'stok'        => 'required|integer|min:0',
            'kondisi'     => 'required|string|max:50',
        ], [
            'kode_alat.unique' => 'Kode alat sudah digunakan, silakan gunakan kode lain.'
        ]);

        Alat::create([
            'kode_alat'   => $request->kode_alat,
            'nama_alat'   => $request->nama_alat,
            'kategori_id' => $request->kategori_id,
            'stok'        => $request->stok,
            'kondisi'     => $request->kondisi,
        ]);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit alat
     */
    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('alat.edit', compact('alat', 'kategori'));
    }

    /**
     * Mengupdate data alat
     */
    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'kode_alat'   => 'required|string|max:50|unique:alat,kode_alat,' . $alat->id,
            'nama_alat'   => 'required|string|max:150',
            'kategori_id' => 'required|exists:kategori,id',
            'stok'        => 'required|integer|min:0',
            'kondisi'     => 'required|string|max:50',
        ], [
            'kode_alat.unique' => 'Kode alat sudah digunakan oleh alat lain.'
        ]);

        $alat->update([
            'kode_alat'   => $request->kode_alat,
            'nama_alat'   => $request->nama_alat,
            'kategori_id' => $request->kategori_id,
            'stok'        => $request->stok,
            'kondisi'     => $request->kondisi,
        ]);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil diperbarui');
    }

    /**
     * Menghapus data alat
     */
    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        $alat->delete();

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil dihapus');
    }
}
