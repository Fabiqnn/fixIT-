<?php

namespace App\Http\Controllers;

use App\Models\admin\FasilitasModel;
use App\Models\admin\GedungModel;
use App\Models\admin\LantaiModel;
use App\Models\admin\RuanganModel;
use Illuminate\Http\Request;

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
