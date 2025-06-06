<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    // Halaman dashboard mahasiswa
    public function index()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));

    }

    // Contoh halaman profil mahasiswa (jika ingin dibuat)
    // public function profile()
    // {
    //     $user = Auth::user();
    //     return view('mahasiswa.profile', compact('user'));
    // }
}
