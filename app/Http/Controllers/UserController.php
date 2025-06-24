<?php

namespace App\Http\Controllers;

use App\Models\LaporanModel;
use App\Models\PeriodeModel;
use App\Models\RekomendasiModel;
use App\Models\UmpanBalikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

class UserController extends Controller
{
    // Halaman dashboard mahasiswa
    public function index()
    {
        $rekomendasi = RekomendasiModel::with('alternatif.laporan.fasilitas')->with('umpanBalik')->get();
        $periode = PeriodeModel::all();

        $user = Auth::user();
        return view('user.dashboard', ['rekomendasi' => $rekomendasi, 'periode' => $periode], compact('user'));
    }

    public function showDetail($id)
    {
        $rekomendasi = RekomendasiModel::with('alternatif.laporan.fasilitas.ruangan.lantai', 'alternatif.laporan.fasilitas.ruangan.gedung', 'umpanBalik.user')
            ->find($id);

        $alt = $rekomendasi->alternatif;

        return response()->json([
            'nama_periode' => $rekomendasi->periode->nama_periode,
            'rekomendasi_id' => $rekomendasi->rekomendasi_id,
            'alternatif' => $rekomendasi->alternatif,
            'fasilitas' => $alt->laporan->fasilitas->nama_fasilitas,
            'status' => $alt->laporan->status_perbaikan,
            'gedung' => $alt->laporan->fasilitas->ruangan->gedung->gedung_nama,
            'lantai' => $alt->laporan->fasilitas->ruangan->lantai->nama_lantai,
            'kode_ruangan' => $alt->laporan->fasilitas->ruangan->kode_ruangan,
            'umpan_balik' => $rekomendasi->umpanBalik->map(function ($feedback) {
                return [
                    'foto_profile' => $feedback->user->foto,
                    'nama' => $feedback->user->nama_lengkap,
                    'komentar' => $feedback->komentar,
                    'skala_kepuasan' => $feedback->skala_kepuasan,
                    'tanggal' => $feedback->created_at->format('Y-m-d')
                ];
            }),
        ]);
    }

    public function penilaian($id)
    {
        $rekomendasi = RekomendasiModel::with('alternatif.laporan.fasilitas.ruangan.lantai', 'alternatif.laporan.fasilitas.ruangan.gedung')
            ->find($id);

        return view('user.status.penilaian', ['rekomendasi' => $rekomendasi]);
    }

    public function umpanBalik(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'rekomendasi_id' => 'required|integer',
                'no_induk' => 'required|string',
                'komentar' => 'required|string|max:2000',
                'skala_kepuasan' => 'required|integer',
                'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $fotoPath = null;

            if ($request->hasFile('picture')) {
                $foto = $request->file('picture');
                $filename = uniqid() . '.' . $foto->getClientOriginalExtension();
                $destinationPath = public_path('uploads/kerusakan');
                // Buat folder jika belum ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $foto->move($destinationPath, $filename);

                // Simpan path relatif dari file untuk ditampilkan nanti
                $fotoPath = 'uploads/kerusakan/' . $filename;
            }

            $check = RekomendasiModel::find($request->rekomendasi_id);
            if ($check) {
                $data = [
                    'rekomendasi_id' => $request->rekomendasi_id,
                    'no_induk' => $request->no_induk,
                    'komentar' => $request->komentar,
                    'skala_kepuasan' => $request->skala_kepuasan,
                    'picture' => $fotoPath,
                ];
                UmpanBalikModel::create($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Komentar anda berhasil disimpan'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $request->rekomendasi_id,
                    'msgField' => $validator->errors()
                ]);
            }
        }
    }
}
