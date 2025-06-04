<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\SPK\AlternatifModel;
use App\Models\SPK\PenilaianModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SPKController extends Controller
{
    public function ambilBarisPenilaian($alternatif_id) {
        $penilaian = PenilaianModel::where('alternatif_id', $alternatif_id)->get();
        $fasilitas = AlternatifModel::with('laporan')
            ->find($alternatif_id);

        $k1 = $this->hitungTotalPelapor($fasilitas->laporan->fasilitas_id);
        $k5 = $this->hitungRentangHari($fasilitas->laporan->fasilitas_id);

        $barisPerbandingan = [];

        foreach ($penilaian as $p) {
            $barisPerbandingan['K' . $p->kriteria_id] = $p->nilai;
        }

        $barisPerbandingan['K1'] = $k1;
        $barisPerbandingan['K5'] = $k5;

        return $barisPerbandingan;
    }

    public function hitungTotalPelapor($fasilitas_id) {
        $laporan = LaporanModel::where('fasilitas_id', $fasilitas_id)
            ->distinct('no_induk')
            ->count('no_induk');
        
        return $laporan;
    }

    public function hitungRentangHari($fasilitas_id) {
        $firstLaporan = LaporanModel::where('fasilitas_id', $fasilitas_id)
            ->orderBy('tanggal_laporan', 'asc')
            ->value('tanggal_laporan');
        
        $rentangHari = $firstLaporan ? now()->diffInDays(\Carbon\Carbon::parse($firstLaporan)) :0;
        
        return $rentangHari;
    }

    public function operasiMABAC() {
        $penilaian = PenilaianModel::all();
        
        $tabelKeputusan = [];

        foreach ($penilaian->groupBy('alternatif_id') as $alternatif_id => $data) {
            $tabelKeputusan[] = [
                'alternatif_id' => $alternatif_id,
                'nilai' => $this->ambilBarisPenilaian($alternatif_id)
            ];
        }

        return response()->json([
            'status' => true,
            'data' => $tabelKeputusan
        ]);
    }
}
