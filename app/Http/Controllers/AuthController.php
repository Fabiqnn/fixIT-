<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'noInduk' => 'required|string|min:10',
            'pass'    => 'required|string|min:6',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        // Kredensial disesuaikan dengan kolom di tabel users
        $credentials = [
            'no_induk' => $request->noInduk,
            'password' => $request->pass
        ];

        // Coba autentikasi
        if (Auth::attempt($credentials)) {
            return response()->json([
                'status'   => true,
                'message'  => 'Login berhasil',
                'redirect' => route('/') 
            ]);
        }

        // Jika gagal login
        return response()->json([
            'status'   => false,
            'message'  => 'No Induk atau password salah',
            'msgField' => [
                'noInduk' => ['No Induk atau password salah.']
            ]
        ]);
    }
}
