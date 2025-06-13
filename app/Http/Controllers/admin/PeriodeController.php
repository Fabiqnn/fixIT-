<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\FasilitasModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PeriodeController extends Controller
{
    public function index() {
        $page = (object) [
            'title' => 'Periode',
            'header' => 'Manajemen Validasi Periode'
        ];

        $activeMenu = 'periode';

        return view('admin.periode.index', ['page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list() {
        $periode = PeriodeModel::all();

        return DataTables::of($periode) 
            ->addIndexColumn()
            ->addColumn('aksi', function ($periode) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/periode/'. $periode->periode_id . '/edit') . '\')" class="button1">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/periode/'. $periode->periode_id . '/delete') . '\')" class="button-error">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function edit($id) {
        $periode = PeriodeModel::find($id);

        return view('admin.periode.edit', ['periode' => $periode]);
    }

    public function update(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_periode' => 'required|string|max:100',  
                'tanggal_mulai' => 'required|date',  
                'tanggal_selesai' => 'required|date',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = PeriodeModel::find($id);
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

    public function create() {
        return view('admin.periode.tambah');
    }

    public function store(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_periode' => 'required|string|max:100',  
                'tanggal_mulai' => 'required|date',  
                'tanggal_selesai' => 'required|date',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            PeriodeModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data periode berhasil disimpan'
            ]);

            redirect('/');
        }
    }

    public function delete($id) {
        $periode = PeriodeModel::find($id);

        return view('admin.periode.delete', ['periode' => $periode]);
    }

    public function confirm(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $periode = PeriodeModel::find($id);
            if ($periode) {
                $periode->delete();
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
                'message' => 'Data bukan merupakan ajax'
            ]);
        }
    }
}
