<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FasilitasModel;
use App\Models\GedungModel;
use App\Models\RuanganModel;
use App\Models\LantaiModel;

class PelaporanController extends Controller
{
    public function index()
    {
        return view('user.laporankerusakan', [
            'fasilitas' => FasilitasModel::all(),
            'gedung'    => GedungModel::all(),
            'ruangan'   => RuanganModel::all(),
            'lantai'    => LantaiModel::all(),
        ]);
    }
}

