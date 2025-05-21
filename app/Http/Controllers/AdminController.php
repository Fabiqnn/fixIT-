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
        $fasilitas = FasilitasModel::select('fasilitas_id', 'nama_fasilitas', 'kode_fasilitas', 'gedung_id', 'tanggal_pengadaan')
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

    public function tambah_ajax_gedung()
    {
        return view('admin.gedung.tambah_ajax');
    }

    public function gedung()
    {
        $page = (object) [
            'title' => 'Gedung',
            'header' => 'Manajemen Gedung'
        ];

        $activeMenu = 'gedung';

        return view('admin.gedung.building', ['page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list_gedung(Request $request)
    {
        $gedung = GedungModel::select('gedung_id', 'gedung_nama');

        return DataTables::of($gedung)
            ->addIndexColumn()
            ->addColumn('aksi', function ($item) {
                return '
        <div class="flex justify-end gap-2">
            <button onclick="modalAction(\'' . url('/admin/building/' . $item->gedung_id . '/show') . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>
            <button onclick="modalAction(\'' . url('/admin/building/' . $item->gedung_id . '/edit_ajax') . '\')" class="px-3 py-1 button1 cursor-pointer">Edit</button>
            <button onclick="modalAction(\'' . url('/admin/building/' . $item->gedung_id . '/delete_ajax') . '\')" class="px-3 py-1 button-error cursor-pointer">Hapus</button>
        </div>
    ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'gedung_nama' => 'required|string|max:100'
        ]);

        GedungModel::create([
            'gedung_nama' => $request->gedung_nama
        ]);

        return redirect('/admin/building')->with('success', 'Data gedung berhasil disimpan');
    }
}
