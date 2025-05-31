<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Models\FasilitasModel;
use App\Models\admin\GedungModel;
use App\Models\UserModels;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class GedungController extends Controller
{
    public function gedung()
    {
        $page = (object) [
            'title' => 'Gedung',
            'header' => 'Manajemen Gedung'
        ];

        $activeMenu = 'gedung';

        return view('admin.gedung.index', ['page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list_gedung(Request $request)
    {
        $gedung = GedungModel::select('gedung_id', 'gedung_nama');

        return DataTables::of($gedung)
            ->addIndexColumn()
            ->addColumn('aksi', function ($item) {
                return '
                <div class="flex justify-end gap-2">
                    <button onclick="modalAction(\'' . url('/admin/gedung/' . $item->gedung_id . '/show') . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>
                    <button onclick="modalAction(\'' . url('/admin/gedung/' . $item->gedung_id . '/edit_ajax') . '\')" class="px-3 py-1 button1 cursor-pointer">Edit</button>
                    <button onclick="modalAction(\'' . url('/admin/gedung/' . $item->gedung_id . '/delete_ajax') . '\')" class="px-3 py-1 button-error cursor-pointer">Hapus</button>
                </div>
            ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tambah_ajax_gedung()
    {
        return view('admin.gedung.tambah_ajax');
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'gedung_nama' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            GedungModel::create([
                'gedung_nama' => $request->gedung_nama
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data gedung berhasil disimpan'
            ]);
        }

        return redirect('/admin/building');
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
        if ($request->ajax() || $request->wantsJson()) {

            $validator = Validator::make($request->all(), [
                'gedung_nama' => 'required|string|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $gedung = GedungModel::find($id);
            if ($gedung) {
                $gedung->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    }



    public function confirm($id)
    {
        $gedung = GedungModel::find($id);

        return view('admin.gedung.confirm_ajax', ['gedung' => $gedung]);
    }
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $gedung = GedungModel::find($id);
            if ($gedung) {
                $gedung->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak Berupa ajax json'
            ]);
        }
    }

    public function show($id)
    {
        $gedung = GedungModel::find($id);

        return view('admin.gedung.show', ['gedung' => $gedung]);
    }
}
