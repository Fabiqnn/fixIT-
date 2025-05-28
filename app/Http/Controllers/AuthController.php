<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModels;

class AuthController extends Controller
{
    public function landing()
    {
        if (Auth::check()) {
            $user = Auth::user();

            return match ((int) $user->level_id) {
                1 => redirect()->route('mahasiswa.dashboard'),
                2 => redirect()->route('admin.dashboard'),
                3 => redirect()->route('dosen.dashboard'),
                default => redirect()->route('dashboard'),
            };
        }

        return response()
            ->view('landingpage')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function showLogin()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'noInduk' => 'required|string|min:10',
            'pass'    => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            Log::info('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $user = UserModels::where('no_induk', $request->noInduk)->first();

        if (!$user || !Hash::check($request->pass, $user->password)) {
            return response()->json([
                'status'   => false,
                'message'  => 'Nomor Induk atau password salah',
                'msgField' => [
                    'noInduk' => ['Nomor Induk atau password salah.']
                ]
            ]);
        }

        Auth::login($user);

        $redirect = match((int) $user->level_id) {
            1 => route('mahasiswa.dashboard'),
            2 => route('admin.dashboard'),
            3 => route('dosen.dashboard'),
            default => route('dashboard')
        };

        return response()->json([
            'status'   => true,
            'message'  => 'Login berhasil',
            'redirect' => $redirect
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
