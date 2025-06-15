<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Debug\VirtualRequestStack;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\admin\FasilitasModel;
use App\Models\admin\GedungModel;
use App\Models\admin\LantaiModel;
use App\Models\admin\RuanganModel;

class FasilitasController extends Controller
{
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
        $fasilitas = FasilitasModel::select('fasilitas_id', 'nama_fasilitas', 'kode_fasilitas', 'tanggal_pengadaan', 'status', 'ruangan_id')
            ->with(['ruangan.gedung', 'ruangan.lantai']);

        if ($request->gedung_id) {
            $fasilitas->whereHas('ruangan', function($query) use ($request) {
                $query->where('gedung_id', $request->gedung_id);
            });
        }

        return DataTables::of($fasilitas)
            ->addIndexColumn()
            ->addColumn('gedung_nama', function ($item) {
                return $item->ruangan ? $item->ruangan->gedung->gedung_nama : '-';
            })
            ->addColumn('kode_ruangan', function ($item) {
                return $item->ruangan ? $item->ruangan->kode_ruangan : '-';
            })
            ->addColumn('nama_lantai', function ($item) {
                return $item->ruangan ? $item->ruangan->lantai->nama_lantai : '-';
            })
            ->addColumn('aksi', function ($fasilitas) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/fasilitas/'. $fasilitas->fasilitas_id . '/show') . '\')" class="button-info">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/fasilitas/'. $fasilitas->fasilitas_id . '/edit') . '\')" class="button1">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/fasilitas/'. $fasilitas->fasilitas_id . '/delete_ajax') . '\')" class="button-error">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tambah_ajax_fasilitas(Request $request)
    {
        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();

        if ($request->gedung_id) {
            $gedung->whereHas('ruangan', function($query) use ($request) {
                $query->where('gedung_id', $request->gedung_id);
            });
        }


        return view('admin.fasilitas.tambah_ajax', ['gedung' => $gedung]);
    }

    public function store_fasilitas(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'ruangan_id' => 'required|integer',
                'kode_fasilitas' => 'required|string|min:3|unique:table_fasilitas,kode_fasilitas',
                'nama_fasilitas' => 'required|string|max:100',
                'tanggal_pengadaan' => 'required|date'
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

        FasilitasModel::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data fasilitas berhasil disimpan'
        ]);

        redirect('/');;
    }

    public function confirm($id) {
        $fasilitas = FasilitasModel::find($id);

        return view('admin.fasilitas.delete', ['fasilitas' => $fasilitas]);
    }

    public function delete_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $fasilitas = FasilitasModel::find($id);
            if ($fasilitas) {
                $fasilitas->delete();
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
        // return redirect('admin/fasilitas');
    }

    public function show($id) {
        $fasilitas = FasilitasModel::find($id);

        return view('admin.fasilitas.show', ['fasilitas' => $fasilitas]);
    }

    public function edit($id) {
        $fasilitas = FasilitasModel::find($id);
        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();
        $lantai = LantaiModel::select('id_lantai', 'nama_lantai')->get();
        $ruangan = RuanganModel::select('id_ruangan', 'kode_ruangan')->get();

        return view('admin.fasilitas.edit', ['fasilitas' => $fasilitas, 'gedung' => $gedung , 'lantai' => $lantai, 'ruangan' => $ruangan]);
    }

    public function update(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'ruangan_id' => 'integer',
                'kode_fasilitas' => 'required|string|min:3|unique:table_fasilitas,kode_fasilitas,' . $id . ',fasilitas_id',
                'nama_fasilitas' => 'required|string|max:100',
                'tanggal_pengadaan' => 'required|date',
                'status' => 'required|string'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = FasilitasModel::find($id);
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

    public function getLantai($gedung_id) {
        $lantai = LantaiModel::where('gedung_id', $gedung_id)->get(['id_lantai', 'nama_lantai']);
        return response()->json($lantai);
    }

    public function getRuangan($id_lantai) {
        $ruangan = RuanganModel::where('id_lantai', $id_lantai)->get(['id_ruangan', 'kode_ruangan']);
        return response()->json($ruangan);
    }
}
