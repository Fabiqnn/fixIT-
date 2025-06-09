<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanModel;
use App\Models\RekomendasiModel;
use App\Models\admin\FasilitasModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\LevelModel;
use App\Models\UserModels;




class TeknisiController extends Controller
{

    public function index()
    {
        $page = (object) [
            'title' => 'Dashboard',
            'header' => 'Dashboard'
        ];

        $activeMenu = 'dashboard';

        return view('teknisi.dashboard', ['page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function tugasBaru()
    {
        return view('teknisi.tugas-baru');
    }


    public function selesai()
    {
        $page = (object) [
            'title' => 'Tugas Diproses',
            'header' => 'Tugas Diproses'
        ];
        $periodeList = DB::table('table_periode')->orderBy('tanggal_mulai', 'desc')->get();
        $activeMenu = 'selesai';
        return view('teknisi.tugas_selesai', ['page' => $page, 'activeMenu' => $activeMenu], compact('periodeList'));
    }


    public function list_diproses(Request $request)
    {
        $query = RekomendasiModel::with([
            'alternatif.laporan.fasilitas.ruangan.gedung',
            'periode'
        ])
            ->whereHas('alternatif.laporan', function ($q) {
                $q->where('status_perbaikan', 'diproses');
            });
        if ($request->has('order')) {
            $columns = [
                'id',
                'ranking',
                'kode_laporan',
                'nama_fasilitas',
                'nama_ruangan',
                'nama_gedung',
                'nama_lantai',
                'status_perbaikan',
                'aksi'
            ];

            $orderColIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir');

            if (isset($columns[$orderColIndex]) && $columns[$orderColIndex] === 'ranking') {
                $query->orderBy('ranking', $orderDir);
            }
        } else {
            $query->orderBy('ranking', 'asc');
        }

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('ranking', function ($row) {
                return (int) $row->ranking;
            })

            ->addColumn('kode_laporan', function ($row) {
                return $row->alternatif->first()?->laporan?->kode_laporan ?? '-';
            })

            ->addColumn('nama_fasilitas', function ($row) {
                return $row->alternatif->first()?->laporan?->fasilitas?->nama_fasilitas ?? '-';
            })

            ->addColumn('nama_ruangan', function ($row) {
                return $row->alternatif->first()?->laporan?->fasilitas?->ruangan?->keterangan ?? '-';
            })

            ->addColumn('nama_gedung', function ($row) {
                return $row->alternatif->first()?->laporan?->fasilitas?->ruangan?->gedung?->gedung_nama ?? '-';
            })

            ->addColumn('nama_lantai', function ($row) {
                return $row->alternatif->first()?->laporan?->fasilitas?->ruangan?->lantai?->nama_lantai ?? '-';
            })

            ->addColumn('status_perbaikan', function ($row) {
                return $row->alternatif->first()?->laporan?->status_perbaikan ?? '-';
            })

            ->addColumn('aksi', function ($row) {
                $laporanId = $row->alternatif->first()?->laporan?->laporan_id ?? null;
                if (!$laporanId) return '-';
                $fasilitasId = $row->alternatif->first()?->laporan?->fasilitas_id ?? null;

                $detailBtn = '<button onclick="modalAction(\'' . url('/teknisi/list_diproses/' . $laporanId . '/show') . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>';
                // $konfirmasiBtn = '<button onclick="modalAction(\'' . url('/teknisi/laporan/' . $laporanId . '/confirm_tuntas') . '\')" class="px-3 py-1 button2 bg-green-600 text-white hover:bg-green-700 cursor-pointer">Update</button>';
                $konfirmasiBtn = '<button onclick="modalAction(\'' . url('/teknisi/laporan/' . $fasilitasId . '/confirm_tuntas') . '\')" class="px-3 py-1 button2 bg-green-600 text-white hover:bg-green-700 cursor-pointer">Update</button>';

                return '
                <div class="flex justify-end gap-2">
                    ' . $detailBtn . '
                    ' . $konfirmasiBtn . '
                </div>';
            })

            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function list_selesai(Request $request)
    {
        $subquery = DB::table('table_laporan as l1')
            ->select(DB::raw('MAX(l1.laporan_id) as max_id'))
            ->where('status_perbaikan', 'tuntas')
            ->groupBy('fasilitas_id');

        $query = LaporanModel::with(['fasilitas.ruangan.gedung', 'rekomendasi.periode'])
            ->whereIn('laporan_id', $subquery);

        if ($request->has('periode_id') && $request->periode_id != '') {
            $query->whereHas('rekomendasi', function ($q) use ($request) {
                $q->where('periode_id', $request->periode_id);
            });
        }



        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('fasilitas_nama', function ($row) {
                return $row->fasilitas->nama_fasilitas ?? '-';
            })
            ->addColumn('ruangan_nama', function ($row) {
                return $row->fasilitas->ruangan->keterangan ?? '-';
            })
            ->addColumn('gedung_nama', function ($row) {
                return $row->fasilitas->ruangan->gedung->gedung_nama ?? '-';
            })
            ->addColumn('lantai', function ($row) {
                return $row->fasilitas->ruangan->lantai->nama_lantai ?? '-';
            })
            ->addColumn('periode_nama', function ($row) {
                return $row->rekomendasi->periode->nama_periode ?? '-';
            })

            ->addColumn('aksi', function ($row) {
                $url = url('/teknisi/list_diproses/' . $row->laporan_id . '/show');
                return '<button onclick="modalAction(\'' . $url . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function confirmTuntas($id)
    {
        $fasilitas = FasilitasModel::findOrFail($id);
        return view('teknisi.confirm_ajax', compact('fasilitas'));
    }


    public function markTuntas($fasilitasId)
    {
        $updated = LaporanModel::where('fasilitas_id', $fasilitasId)
            ->where(function ($q) {
                $q->where('status_perbaikan', 'diproses');
            })
            ->update(['status_perbaikan' => 'tuntas']);
        FasilitasModel::find($fasilitasId)->update([
            'status' => 'baik'
        ]);

        if ($updated === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada laporan yang bisa diupdate.'
            ]);
        }

        return response()->json([
            'success' => true,
            'updated' => $updated
        ]);
    }

    public function show($id)
    {
        $laporan = LaporanModel::with([
            'user',
            'fasilitas.ruangan.gedung',
            'fasilitas.ruangan.lantai'
        ])->findOrFail($id);

        return view('teknisi.show', compact('laporan'));
    }

    public function profile()
    {
        $user = auth()->user();
        $activeMenu = '';
        return view('teknisi.profile', compact('user'), ['activeMenu' => $activeMenu]);
    }

    public function edit_profile($id)
    {
        $user = UserModels::find($id);
        $role = LevelModel::select('level_id', 'level_nama')->get();

        return view('teknisi.edit', ['user' => $user, 'level' => $role]);
    }
    public function update_profile(Request $request, $no_induk)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_lengkap' => 'required|string|max:100',
                'email' => 'nullable|email|max:100',
                'nomor_telp' => 'nullable|string|max:15',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ];

            if ($request->filled('password')) {
                $rules['password'] = 'min:6';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $user = UserModels::where('no_induk', $no_induk)->first();
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User tidak ditemukan']);
            }

            $data = $request->only(['nama_lengkap', 'email', 'nomor_telp']);

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $namaFile = $user->no_induk . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('uploads/foto'), $namaFile);
                $data['foto'] = $namaFile;
            }

            $user->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data profil berhasil diperbarui'
            ]);
        }
    }
}
