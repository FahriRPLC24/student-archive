<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_type' => 'required|in:staff,siswa',
        ]);

        if ($request->login_type === 'staff') {

            $request->validate([
                'nip' => 'required|string',
                'password' => 'required',
            ]);

            $user = User::where('nip', $request->nip)->first();

            if ($user && \Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();

                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->hasRole('guru')) {
                    return redirect()->route('guru.dashboard');
                }
            }

            return back()->withErrors(['nip' => 'NIP atau password salah.']);
            
        } else {

            $request->validate([
                'nis' => 'required|string',
                'tanggal_lahir' => 'required|date',
            ]);

            
            $user = User::where('nis', $request->nis)
                        ->where('nip', $request->tanggal_lahir)
                        ->where('role', 'siswa')
                        ->first();

            if ($user) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('siswa.dashboard');
            }

            return back()->withErrors(['nis' => 'NIS atau Tanggal Lahir tidak ditemukan.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}