<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user (Admin & Piket).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
        })
        ->orderBy('name', 'asc')
        ->paginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Tampilkan form pembuatan user baru.
     */
    public function create()
    {
        $user = new User();
        return view('admin.users.form', compact('user'));
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'role'     => 'required|in:admin,piket',
            'password' => 'required|string|min:6',
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username ini sudah digunakan oleh akun lain.',
            'role.required'     => 'Role pengguna wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User pengguna baru berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.form', compact('user'));
    }

    /**
     * Perbarui data user di database.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role'     => 'required|in:admin,piket',
            'password' => 'nullable|string|min:6',
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username ini sudah digunakan oleh akun lain.',
            'role.required'     => 'Role pengguna wajib dipilih.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Hapus user dari database.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah hapus akun sendiri saat sedang login
        if (Auth::id() == $user->id) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dihapus!');
    }
}
