<?php

namespace App\Http\Controllers;

use App\Models\admin\FasilitasModel;
use App\Models\admin\GedungModel;
use App\Models\admin\LantaiModel;
use App\Models\admin\RuanganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PelaporanController extends Controller
{
    public function index()
    {
        return view('user.Laporan.create', [
            'fasilitas' => FasilitasModel::all(),
            'gedung'    => GedungModel::all(),
            'ruangan'   => RuanganModel::all(),
            'lantai'    => LantaiModel::all(),
        ]);
    }

    public function getLantai(Request $request)
    {
        $gedungId = $request->get('gedung_id');

        $lantai = LantaiModel::where('gedung_id', $gedungId)->get(['id_lantai', 'nama_lantai']);
        return response()->json($lantai);
    }

    public function getRuangan(Request $request)
    {
        $gedungId = $request->get('gedung_id');
        $lantaiId = $request->get('lantai_id');

        $ruangan = RuanganModel::where('gedung_id', $gedungId)
            ->where('id_lantai', $lantaiId)
            ->get(['id_ruangan', 'keterangan']);

        return response()->json($ruangan);
    }

    public function getFasilitas(Request $request)
    {
        $ruanganId = $request->get('ruangan_id');

        $fasilitas = FasilitasModel::where('ruangan_id', $ruanganId)
            ->get(['fasilitas_id', 'nama_fasilitas']);

        return response()->json($fasilitas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fasilitas_id' => 'required|exists:table_fasilitas,fasilitas_id',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string|max:2000',
        ]);

        $user = Auth::user();
        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
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

        // Ambil kode laporan terakhir
        $lastKode = DB::table('table_laporan')
            ->select('kode_laporan')
            ->orderByDesc('kode_laporan')
            ->first();

        if ($lastKode) {
            // Misal lastKode = "LAP-007", ambil angka 007
            $lastNumber = (int) str_replace('LAP-', '', $lastKode->kode_laporan);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format kode laporan baru, misal: LAP-001
        $newKodeLaporan = 'LAP-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        DB::table('table_laporan')->insert([
            'kode_laporan' => $newKodeLaporan,
            'no_induk' => $user->no_induk,
            'fasilitas_id' => $request->fasilitas_id,
            'tanggal_laporan' => now(),
            'deskripsi_kerusakan' => $request->deskripsi,
            'status_perbaikan' => 'diproses',
            'status_acc' => 'pending',
            'foto_kerusakan' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }
}
