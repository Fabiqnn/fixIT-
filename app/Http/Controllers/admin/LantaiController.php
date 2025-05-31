<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\admin\GedungModel;
use App\Models\admin\LantaiModel;

class LantaiController extends Controller
{
    public function index() {
        $page = (object) [
            'title' => 'Lantai',
            'header' => 'Manajemen Lantai'
        ];

        $activeMenu = 'lantai';

        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();

        return view('admin.lantai.index', ['page' => $page, 'activeMenu' => $activeMenu, 'gedung' => $gedung]);
    }

    public function list(Request $request)
    {
        $lantai = LantaiModel::select('id_lantai', 'nama_lantai', 'gedung_id')
            ->with('gedung');

        if ($request->gedung_id) {
            $lantai->where('gedung_id', $request->gedung_id);
        }

        return DataTables::of($lantai)
            ->addIndexColumn()
            ->addColumn('gedung_nama', function ($item) {
                return $item->gedung ? $item->gedung->gedung_nama : '-';
            })
            ->addColumn('aksi', function ($lantai) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/lantai/'. $lantai->id_lantai . '/show') . '\')" class="button-info">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/lantai/'. $lantai->id_lantai . '/edit') . '\')" class="button1">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/lantai/'. $lantai->id_lantai . '/delete_ajax') . '\')" class="button-error">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tambah_ajax()
    {
        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();

        return view('admin.lantai.tambah_ajax', ['gedung' => $gedung]);
    }

    public function store(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'gedung_id' => 'required|integer',
                'nama_lantai' => 'required|string|max:100',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        LantaiModel::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data fasilitas berhasil disimpan'
        ]);

        redirect('/');;
    }

    public function show($id) {
        $lantai = LantaiModel::find($id);

        return view('admin.lantai.show', ['lantai' => $lantai]);
    }

    public function edit($id) {
        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();
        $lantai = LantaiModel::find($id);

        return view('admin.lantai.edit', ['gedung' => $gedung, 'lantai' => $lantai]);
    }

    public function update(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'gedung_id' => 'required|integer',
                'nama_lantai' => 'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = LantaiModel::find($id);
            if ($check) {
                $check->update($request->all());
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

    public function confirm($id) {
        $lantai = LantaiModel::find($id);

        return view('admin.lantai.delete', ['lantai' => $lantai]);
    }

    public function delete_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $lantai = LantaiModel::find($id);
            if ($lantai) {
                $lantai->delete();
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
}
