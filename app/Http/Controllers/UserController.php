<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $allData = User::get();
        $users = User::orderBy('name', 'asc')->paginate(5);
        return view('users.index', compact('users', 'allData'));
    }

    /**
     * Menampilkan form tambah user
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email' => 'required|string|max:50|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,petugas,peminjam',
        ], [
            'email.unique' => 'email sudah digunakan'
        ]);

        User::create([
            'name'     => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Mengupdate data user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:100',
            'email' => 'required|string|max:50|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role'     => 'required|in:admin,petugas,peminjam',
        ]);

        $data = [
            'name'     => $request->name,
            'email' => $request->email,
            'role'     => $request->role,
        ];

        // password hanya diupdate jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Menghapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // optional: cegah hapus diri sendiri
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
