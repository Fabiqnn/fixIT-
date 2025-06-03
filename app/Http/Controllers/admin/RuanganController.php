<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\admin\GedungModel;
use App\Models\admin\LantaiModel;
use App\Models\admin\RuanganModel;

class RuanganController extends Controller
{
    public function index() {
        $page = (object) [
            'title' => 'Ruangan',
            'header' => 'Manajemen Ruangan'
        ];

        $activeMenu = 'ruangan';

        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();

        return view('admin.ruangan.index', ['page' => $page, 'activeMenu' => $activeMenu, 'gedung' => $gedung]);
    }

    public function list(Request $request)
    {
        $ruangan = RuanganModel::select('id_ruangan', 'kode_ruangan', 'gedung_id', 'keterangan', 'id_lantai')
            ->with(['gedung', 'lantai']);

        if ($request->gedung_id) {
            $ruangan->where('gedung_id', $request->gedung_id);
        }

        return DataTables::of($ruangan)
            ->addIndexColumn()
            ->addColumn('gedung_nama', function ($item) {
                return $item->gedung ? $item->gedung->gedung_nama : '-';
            })
            ->addColumn('nama_lantai', function ($item) {
                return $item->lantai ? $item->lantai->nama_lantai : '-';
            })
            ->addColumn('aksi', function ($ruangan) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/ruangan/'. $ruangan->id_ruangan . '/show') . '\')" class="button-info">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/ruangan/'. $ruangan->id_ruangan . '/edit') . '\')" class="button1">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/ruangan/'. $ruangan->id_ruangan . '/delete_ajax') . '\')" class="button-error">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function getLantai($gedung_id) {
        $lantai = LantaiModel::where('gedung_id', $gedung_id)->get(['id_lantai', 'nama_lantai']);
        return response()->json($lantai);
    }

    public function tambah_ajax()
    {
        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();

        return view('admin.ruangan.tambah_ajax', ['gedung' => $gedung]);
    }

    public function store(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_gedung' => 'required|integer',
                'id_lantai' => 'required|integer',
                'kode_ruangan' => 'required|string',
                'kode_ruangan' => [
                    'required',
                    'string',
                    'min:3',
                    Rule::unique('table_ruangan')->where(function ($query) use ($request) {
                        return $query->where('gedung_id', $request->id_gedung)
                                    ->where('id_lantai', $request->id_lantai);
                    }),
                ],
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Nama Ruangan Tidak Boleh Sama di Gedung dan Lantai yang Sama',
                'msgField' => $validator->errors()
            ]);
        }

        $data = [
            'gedung_id' => $request->id_gedung,
            'id_lantai' => $request->id_lantai,
            'kode_ruangan' => $request->kode_ruangan,
            'keterangan' => $request->keterangan
        ];

        RuanganModel::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Data fasilitas berhasil disimpan'
        ]);

        redirect('/');
    }

    public function show($id) {
        $ruangan = RuanganModel::find($id);

        return view('admin.ruangan.show', ['ruangan' => $ruangan]);
    }

    public function edit($id) {
        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();
        $lantai = LantaiModel::select('id_lantai', 'nama_lantai')->get();
        $ruangan = RuanganModel::find($id);

        return view('admin.ruangan.edit', ['gedung' => $gedung, 'lantai' => $lantai, 'ruangan' => $ruangan]);
    }

    public function update(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_gedung' => 'required|integer',
                'id_lantai' => 'required|integer',
                'kode_ruangan' => 'required|string',
                'kode_ruangan' => [
                    'required',
                    'string',
                    'min:3',
                    Rule::unique('table_ruangan')->where(function ($query) use ($request) {
                        return $query->where('gedung_id', $request->id_gedung)
                                    ->where('id_lantai', $request->id_lantai);
                    }),
                ],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Nama Ruangan Tidak Boleh Sama di Gedung dan Lantai yang Sama',
                    'msgField' => $validator->errors()
                ]);
            }

            $data = [
                'gedung_id' => $request->id_gedung,
                'id_lantai' => $request->id_lantai,
                'kode_ruangan' => $request->kode_ruangan,
                'keterangan' => $request->keterangan
            ];

            $check = RuanganModel::find($id);
            if ($check) {
                $check->update($data);
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
        $ruangan = RuanganModel::find($id);

        return view('admin.ruangan.delete', ['ruangan' => $ruangan]);
    }

    public function delete_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $ruangan = RuanganModel::find($id);
            if ($ruangan) {
                $ruangan->delete();
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
