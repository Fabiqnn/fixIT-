<?php

namespace App\Http\Controllers;

use App\Models\FasilitasModel;
use App\Models\GedungModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        $page = (object) [
            'title' => 'Dashboard',
            'header' => 'Dashboard'
        ];

        $activeMenu = 'dashboard';

        return view('admin.dashboard', ['page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function fasilitas()
    {
        $page = (object) [
            'title' => 'Fasilitas',
            'header' => 'Manajemen Fasilitas'
        ];

        $activeMenu = 'fasilitas';

        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();

        return view('admin.fasilitas.index', ['page' => $page, 'activeMenu' => $activeMenu, 'gedung' => $gedung]);
    }

    public function list_fasilitas(Request $request) 
    {
        $fasilitas = FasilitasModel::select('fasilitas_id', 'nama_fasilitas', 'kode_fasilitas', 'gedung_id','tanggal_pengadaan')
            ->with('Gedung');

        if ($request->gedung_id) {
            $fasilitas->where('gedung_id', $request->gedung_id);
        }

        return DataTables::of($fasilitas)
            ->addIndexColumn()
            ->addColumn('gedung_nama', function ($item) {
                return $item->Gedung ? $item->Gedung->gedung_nama : '-';
            })
            ->addColumn('aksi', function ($fasilitas) {
                $btn = '<button onclick="modalAction(\'' . '\')" class="button-info">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . '\')" class="button1">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . '\')" class="button-error">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tambah_ajax_fasilitas() 
    {
        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();

        return view('admin.fasilitas.tambah_ajax', ['gedung' => $gedung]);
    }


    public function user()
    {
        $page = (object) [
            'title' => 'User',
            'header' => 'User Management'
        ];

        $activeMenu = 'user';

        return view('admin.userManagement', ['page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function tes()
    {


        return view('admin.userCreateAjax');
    }

    public function createAjax()
    {
        return view('admin.userCreateAjax');
    }

    public function building()
    {
        $page = (object) [
            'title' => 'Building',
            'header' => 'Building Management'
        ];

        $activeMenu = 'building';

        return view('admin.building', ['page' => $page, 'activeMenu' => $activeMenu]);
    }
}
