<?php

namespace App\Http\Controllers;

use App\Models\FasilitasModel;
use App\Models\GedungModel;
use App\Models\UserModels;
use Illuminate\Database\Console\Migrations\StatusCommand;
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

    // user
    public function user()
    {
        $page = (object) [
            'title' => 'User',
            'header' => 'User Management'
        ];

        $activeMenu = 'user';

        return view('admin.user.userManagement', ['page' => $page, 'activeMenu' => $activeMenu]);
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
    public function edit_ajax(string $id)
    {
        $gedung = GedungModel::find($id);

        if (!$gedung) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return view('admin.gedung.edit_ajax', ['gedung' => $gedung]);
    }

    public function update_ajax(Request $request, $id)
    {
        $request->validate([
            'gedung_nama' => 'required|max:100'
        ]);

        $gedung = GedungModel::find($id);

        if (!$gedung) {
            return redirect('/admin/building')->with('error', 'Data tidak ditemukan');
        }

        $gedung->update([
            'gedung_nama' => $request->gedung_nama
        ]);

        return redirect('/admin/building')->with('success', 'Data gedung berhasil diperbarui');
    }

    public function list_user(Request $request)
    {
        $user = UserModels::select('user_id', 'nama_lengkap', 'level_id', 'email', 'nomor_telp')
            ->with('level');

        return DataTables::of($user)
            ->addIndexColumn()

            ->addColumn('level_nama', function ($item) {
                return $item->level->level_nama ?? '-';
            })

            ->addColumn('aksi', function ($item) {
                return '
            <div class="flex justify-end gap-2">
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/show') . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/edit_ajax') . '\')" class="px-3 py-1 button1 cursor-pointer">Edit</button>
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/delete_ajax') . '\')" class="px-3 py-1 button-error cursor-pointer">Hapus</button>
            </div>
            ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
