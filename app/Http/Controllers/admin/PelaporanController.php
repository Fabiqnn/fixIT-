<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\FasilitasModel;
use App\Models\admin\GedungModel;
use App\Models\admin\LantaiModel;
use App\Models\admin\PelaporanModel;
use App\Models\admin\RuanganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PelaporanController extends Controller
{
    public function index() {
        $page = (object) [
            'title' => 'Pelaporan',
            'header' => 'Manajemen Validasi Laporan'
        ];

        $activeMenu = 'laporan';

        $gedung = GedungModel::select('gedung_id', 'gedung_nama')->get();

        return view('admin.pelaporan.index', ['page' => $page, 'activeMenu' => $activeMenu, 'gedung' => $gedung]);
    }

    public function list_pending(Request $request)
    {
        $pelaporan = PelaporanModel::select('laporan_id', 'kode_laporan', 'fasilitas_id', 'tanggal_laporan', 'status_acc')
            ->with(['fasilitas.ruangan.lantai', 'fasilitas.ruangan.gedung'])
            ->where('status_acc', 'pending');

        if ($request->gedung_id_pending) {
            $pelaporan->whereHas('fasilitas.ruangan', function ($query) use ($request) {
                $query->where('gedung_id', $request->gedung_id_pending);
            });
        }

        return DataTables::of($pelaporan)
            ->addIndexColumn()
            ->addColumn('nama_fasilitas', function ($item) {
                return $item->fasilitas->nama_fasilitas ?? '-';
            })
            ->addColumn('nama_ruangan', function ($item) {
                return $item->fasilitas->ruangan->kode_ruangan ?? '-';
            })
            ->addColumn('nama_lantai', function ($item) {
                return $item->fasilitas->ruangan->lantai->nama_lantai ?? '-';
            })
            ->addColumn('nama_gedung', function ($item) {
                return $item->fasilitas->ruangan->gedung->gedung_nama ?? '-';
            })
            ->addColumn('aksi', function ($pelaporan) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/pelaporan/'. $pelaporan->laporan_id . '/show') . '\')" class="button-info">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/pelaporan/'. $pelaporan->laporan_id . '/acc') . '\')" class="button1">Terima</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/pelaporan/'. $pelaporan->laporan_id . '/dec') . '\')" class="button-error">Tolak</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function list_acc(Request $request)
    {
        $pelaporan = PelaporanModel::select('laporan_id', 'kode_laporan', 'fasilitas_id', 'tanggal_laporan', 'status_acc')
            ->with(['fasilitas.ruangan.lantai', 'fasilitas.ruangan.gedung'])
            ->where('status_acc', 'disetujui');

        if ($request->gedung_id_acc) {
            $pelaporan->whereHas('fasilitas.ruangan', function ($query) use ($request) {
                $query->where('gedung_id', $request->gedung_id_acc);
            });
        }

        return DataTables::of($pelaporan)
            ->addIndexColumn()
            ->addColumn('nama_fasilitas', function ($item) {
                return $item->fasilitas->nama_fasilitas ?? '-';
            })
            ->addColumn('nama_ruangan', function ($item) {
                return $item->fasilitas->ruangan->kode_ruangan ?? '-';
            })
            ->addColumn('nama_lantai', function ($item) {
                return $item->fasilitas->ruangan->lantai->nama_lantai ?? '-';
            })
            ->addColumn('nama_gedung', function ($item) {
                return $item->fasilitas->ruangan->gedung->gedung_nama ?? '-';
            })
            ->addColumn('aksi', function ($pelaporan) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/pelaporan/'. $pelaporan->laporan_id . '/show') . '\')" class="button-info">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/pelaporan/'. $pelaporan->laporan_id . '/dec') . '\')" class="button-error">Tolak</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function list_dec(Request $request)
    {
        $pelaporan = PelaporanModel::select('laporan_id', 'kode_laporan', 'fasilitas_id', 'tanggal_laporan', 'status_acc')
            ->with(['fasilitas.ruangan.lantai', 'fasilitas.ruangan.gedung'])
            ->where('status_acc', 'ditolak');

        if ($request->gedung_id_dec) {
            $pelaporan->whereHas('fasilitas.ruangan', function ($query) use ($request) {
                $query->where('gedung_id', $request->gedung_id_dec);
            });
        }

        return DataTables::of($pelaporan)
            ->addIndexColumn()
            ->addColumn('nama_fasilitas', function ($item) {
                return $item->fasilitas->nama_fasilitas ?? '-';
            })
            ->addColumn('nama_ruangan', function ($item) {
                return $item->fasilitas->ruangan->kode_ruangan ?? '-';
            })
            ->addColumn('nama_lantai', function ($item) {
                return $item->fasilitas->ruangan->lantai->nama_lantai ?? '-';
            })
            ->addColumn('nama_gedung', function ($item) {
                return $item->fasilitas->ruangan->gedung->gedung_nama ?? '-';
            })
            ->addColumn('aksi', function ($pelaporan) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/pelaporan/'. $pelaporan->laporan_id . '/show') . '\')" class="button-info">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/pelaporan/'. $pelaporan->laporan_id . '/acc') . '\')" class="button1">Terima</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id) {
        $pelaporan = PelaporanModel::find($id);

        return view('admin.pelaporan.show', ['pelaporan' => $pelaporan]);
    }

    public function edit($id) {
        $pelaporan = PelaporanModel::find($id);

        return view('admin.pelaporan.edit', ['pelaporan' => $pelaporan]);
    }

    public function update(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'deskripsi_kerusakan' => 'required|string|max:100'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = PelaporanModel::find($id);
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

    public function acc($id) {
        $pelaporan = PelaporanModel::find($id);

        return view('admin.pelaporan.acc', ['pelaporan' => $pelaporan]);
    }

    public function dec($id) {
        $pelaporan = PelaporanModel::find($id);

        return view('admin.pelaporan.dec', ['pelaporan' => $pelaporan]);
    }

    public function update_acc(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $fasilitas = PelaporanModel::find($id);
            if ($fasilitas) {
                $fasilitas->update([
                    'status_acc' => 'disetujui'
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil divalidasi'
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

    public function update_dec(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $fasilitas = PelaporanModel::find($id);
            if ($fasilitas) {
                $fasilitas->update([
                    'status_acc' => 'ditolak'
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil ditolak'
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
