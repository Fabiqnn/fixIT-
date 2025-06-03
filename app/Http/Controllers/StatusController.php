<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanModel;
use App\Models\GedungModel;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
  public function index()
{
    $no_induk = Auth::user()->no_induk;

    $laporan = LaporanModel::with(['fasilitas.ruangan.lantai.gedung'])
    ->where('no_induk', Auth::user()->no_induk)
    ->paginate(5);

   
    return view('user.status.statusPelaporan', compact('laporan'));
}

}