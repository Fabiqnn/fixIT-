<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\FasilitasModel;
use App\Models\admin\GedungModel;
use App\Models\admin\PelaporanModel;
use App\Models\LaporanModel;
use App\Models\SPK\AlternatifModel;
use App\Models\SPK\KriteriaModel;
use App\Models\SPK\PenilaianModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PrioritasController extends Controller
{
    public function index()
    {
        $page = (object) [
            'title' => 'Prioritas Perbaikan',
            'header' => 'Manajemen Prioritas'
        ];

        $gedung = GedungModel::all();

        $activeMenu = 'prioritas';

        return view('admin.prioritas.index', ['activeMenu' => $activeMenu, 'page' => $page, 'gedung' => $gedung]);
    }

    public function list_kriteria()
    {
        $kriteria = KriteriaModel::select('kriteria_id', 'nama_kriteria', 'bobot', 'tipe_kriteria');

        return DataTables::of($kriteria)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kriteria) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/prioritas/' . $kriteria->kriteria_id . '/edit-kriteria') . '\')" class="button1">Edit</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function list_alternatif()
    {
        $alternatif = AlternatifModel::select('alternatif_id', 'laporan_id')
            ->with(['laporan.fasilitas.ruangan.gedung', 'laporan.fasilitas.ruangan.lantai', 'laporan.fasilitas.ruangan'])
            ->whereHas('laporan', function($query) {
                $query->whereNull('status_perbaikan');
            });

        return DataTables::of($alternatif)
            ->addIndexColumn()
            ->addColumn('gedung_nama', function ($item) {
                return $item->laporan && $item->laporan->fasilitas && $item->laporan->fasilitas->ruangan && $item->laporan->fasilitas->ruangan->gedung
                    ? $item->laporan->fasilitas->ruangan->gedung->gedung_nama
                    : '-';
            })
            ->addColumn('nama_fasilitas', function ($item) {
                return $item->laporan && $item->laporan->fasilitas 
                    ? $item->laporan->fasilitas->nama_fasilitas
                    : '-';
            })
            ->addColumn('kode_ruangan', function ($item) {
                return $item->laporan && $item->laporan->fasilitas && $item->laporan->fasilitas->ruangan
                    ? $item->laporan->fasilitas->ruangan->kode_ruangan
                    : '-';
            })
            ->addColumn('nama_lantai', function ($item) {
                return $item->laporan && $item->laporan->fasilitas && $item->laporan->fasilitas->ruangan && $item->laporan->fasilitas->ruangan->lantai
                    ? $item->laporan->fasilitas->ruangan->lantai->nama_lantai
                    : '-';
            })
            ->make(true);
    }

    public function list_penilaian()
    {
        $penilaian = PenilaianModel::with(['alternatif', 'kriteria'])->get();

        $kodeMap = [
            1 => 'K1',
            2 => 'K2',
            3 => 'K3',
            4 => 'K4',
            5 => 'K5',
        ];

        $matrix = [];

        foreach ($penilaian as $item) {
            $altId = $item->alternatif_id;
            $altName = $item->alternatif->laporan->fasilitas->nama_fasilitas ?? 'Alternatif-' . $altId;
            $idFasilitas = $item->alternatif->laporan->fasilitas_id;

            $K1 = LaporanModel::where('fasilitas_id', $idFasilitas)
            ->where('status_acc', 'disetujui')
            ->whereNull('status_perbaikan')
            ->select('no_induk')
            ->distinct()
            ->count();

            if (!isset($matrix[$altId])) {
                $matrix[$altId] = [
                    'alternatif_id' => $altId,
                    'alternatif' => $altName,
                    'K1' => $K1,
                    'K2' => '-',
                    'K3' => '-',
                    'K4' => '-',
                    'K5' => '-',
                ];
            }

            $kode = $kodeMap[$item->kriteria_id] ?? null;
            if ($kode) {
                $matrix[$altId][$kode] = $item->nilai;
            }
        }

        return DataTables::of(collect($matrix))
            ->addIndexColumn()
            ->addColumn('aksi', function ($matrix) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/prioritas/' . $matrix['alternatif_id'] . '/edit-alternatif') . '\')" class="button1">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/prioritas/' . $matrix['alternatif_id'] . '/delete-alternatif') . '\')" class="button-error">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tambah_alternatif () 
    {
        $pelaporan = PelaporanModel::selectRaw('MIN(laporan_id) as laporan_id, MIN(kode_laporan) as kode_laporan, fasilitas_id')
            ->where('status_acc', 'disetujui')
            ->whereNull('status_perbaikan')
            ->whereHas('fasilitas', function($query) {
                $query->where('status', '!=', 'dalam perbaikan');
            })
            ->groupBy('fasilitas_id')
            ->with(['fasilitas.ruangan.lantai', 'fasilitas.ruangan.gedung'])
            ->get();

        $namaFasilitas = [];
        foreach ($pelaporan as $p) {
            $fasilitas = $p->fasilitas->nama_fasilitas;
            $namaFasilitas[$p->laporan_id] = $fasilitas;
        }

        return view('admin.prioritas.tambah-alternatif', ['pelaporan' => $pelaporan, 'namaFasilitas' => $namaFasilitas]);
    }

    public function store_alternatif(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'laporan_id' => 'required|exists:table_laporan,laporan_id',
                'K2' => 'required|integer|min:1|max:5', // Skala kerusakan
                'K3' => 'required|integer|min:1|max:5', // Dampak pembelajaran
                'K4' => 'required|numeric|min:0|max: 18446744073709551615', // Estimasi biaya perbaikan
                'K5' => 'required|numeric|min:0|max: 5', // Estimasi biaya perbaikan
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

        $alternatif = AlternatifModel::create([
            'laporan_id' => $request->laporan_id
        ]);
        FasilitasModel::find($alternatif->laporan->fasilitas->fasilitas_id)->update([
            'status' => 'dalam perbaikan'
        ]);

        $penilaianData = [
            ['kriteria_id' => 2, 'nilai' => $request->K2],
            ['kriteria_id' => 3, 'nilai' => $request->K3],
            ['kriteria_id' => 4, 'nilai' => $request->K4],
            ['kriteria_id' => 5, 'nilai' => $request->K5]
        ];

        foreach ($penilaianData as $data) {
            PenilaianModel::create([
                'alternatif_id' => $alternatif->alternatif_id,
                'kriteria_id' => $data['kriteria_id'],
                'nilai' => $data['nilai']
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Alternatif & Penilaian berhasil disimpan'
        ]);

        redirect('/');
    }

    public function edit_kriteria($id)
    {
        $kriteria = KriteriaModel::find($id);

        return view('admin.prioritas.edit-kriteria', ['kriteria' => $kriteria]);
    }

    public function update_kriteria(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'bobot' => 'required|integer',
                'nama_kriteria' => 'required|string|min:3',
                'tipe_kriteria' => 'required|string|'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = KriteriaModel::find($id);
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

    public function edit_alternatif($id) {
        $penilaian = PenilaianModel::with('kriteria', 'alternatif.laporan.fasilitas', 'alternatif')
            ->where('alternatif_id', $id)
            ->get();
        $firstPenilaian = $penilaian->first();

        $nilaiLama = [];
        foreach ($penilaian as $p) {
            $kode = 'K' . $p->kriteria_id;
            $nilaiLama[$kode] = $p->nilai;
        }

        return view('admin.prioritas.edit-alternatif', ['penilaian' => $penilaian, 'firstPenilaian' => $firstPenilaian, 'nilaiLama' => $nilaiLama]);
    }

    public function getLaporan($id)
    {
        $laporan = PelaporanModel::with(['fasilitas.ruangan.lantai', 'fasilitas.ruangan.gedung'])
            ->where('laporan_id', $id)
            ->first();

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Laporan tidak ditemukan.']);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'kode_laporan' => $laporan->kode_laporan,
                'nama_fasilitas' => $laporan->fasilitas->nama_fasilitas ?? '-',
                'gedung_nama' => $laporan->fasilitas->ruangan->gedung->gedung_nama ?? '-',
                'lantai_nama' => $laporan->fasilitas->ruangan->lantai->nama_lantai ?? '-',
                'ruangan_kode' => $laporan->fasilitas->ruangan->kode_ruangan ?? '-',
            ]
        ]);
    }

    public function update_alternatif(Request $request, $id) 
    {
        $rules = [
            'K2' => 'required|integer|min:1|max:5', 
            'K3' => 'required|integer|min:1|max:5', 
            'K4' => 'required|numeric|min:0',       
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $map = [
            'K2' => 2,
            'K3' => 3,
            'K4' => 4,
        ];

        $check = PenilaianModel::where('alternatif_id', $id)->exists();
        if ($check) {
            foreach ($request->all() as $kode => $nilai) {
                if (array_key_exists($kode, $map)) {
                    PenilaianModel::where('alternatif_id', $id)
                        ->where('kriteria_id', $map[$kode])
                        ->update(['nilai' => $nilai]);
                }
            }
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

    public function delete($id) {
        $penilaian = PenilaianModel::with('kriteria', 'alternatif.laporan.fasilitas', 'alternatif')
            ->where('alternatif_id', $id)
            ->get();
        $firstPenilaian = $penilaian->first();

        $nilaiLama = [];
        foreach ($penilaian as $p) {
            $kode = 'K' . $p->kriteria_id;
            $nilaiLama[$kode] = $p->nilai;
        }

        return view('admin.prioritas.delete-alternatif', ['penilaian' => $penilaian, 'firstPenilaian' => $firstPenilaian, 'nilaiLama' => $nilaiLama]);
    }

    public function confirm(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $penilaian = PenilaianModel::where('alternatif_id', $id);
            $alternatif = AlternatifModel::find($id);
            if ($penilaian) {
                $penilaian->delete();
                $alternatif->delete();
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
                'message' => 'Tidak berupa ajax json'
            ]);
        }
    }
}
