<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    private function setActive($page)
    {
        return [
            'activePengguna' => $page,
            'penggunaActive' => true,
        ];
    }
    public function index()
    {
        $users = User::with('role')->get();
        return view('pengguna.index', compact('users'), $this->setActive('pengguna'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|integer',
        ]);

        User::create([
            'nama' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => 'Aktif',
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function resetPassword($id)
    {
        User::where('id', $id)->update([
            'password' => bcrypt('password123')
        ]);

        return back()->with('success', 'Password berhasil direset');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 'Aktif' ? 'Nonaktif' : 'Aktif';
        $user->save();

        return back()->with('success', 'Status pengguna diperbarui');
    }
}
