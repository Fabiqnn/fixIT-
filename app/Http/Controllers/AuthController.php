<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModels;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'noInduk' => 'required|string|min:10', // Sesuaikan panjang minimal sesuai kebutuhan
            'pass'    => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $noInduk = $request->noInduk;

        // Cari user berdasarkan nip atau nim
        $user = UserModels::where('nip', $noInduk)
                    ->orWhere('nim', $noInduk)
                    ->first();

        if (!$user || !Hash::check($request->pass, $user->password)) {
            return response()->json([
                'status'   => false,
                'message'  => 'No Induk atau password salah',
                'msgField' => [
                    'noInduk' => ['No Induk atau password salah.']
                ]
            ]);
        }

        Auth::login($user);

        return response()->json([
            'status'   => true,
            'message'  => 'Login berhasil',
            'redirect' => route('dashboard') // Sesuaikan dengan route tujuan setelah login
        ]);
    }
}
