<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\FasilitasModel;
use App\Models\LaporanModel;
use App\Models\PeriodeModel;
use App\Models\RekomendasiModel;
use App\Models\SPK\AlternatifModel;
use App\Models\SPK\PenilaianModel;
use App\Services\MabacService;
use Illuminate\Http\Request;


class SPKController extends Controller
{
    public function ambilBarisPenilaian($alternatif_id)
    {
        $penilaian = PenilaianModel::where('alternatif_id', $alternatif_id)->get();
        $fasilitas = AlternatifModel::with('laporan')
            ->find($alternatif_id);

        $k1 = $this->hitungTotalPelapor($fasilitas->laporan->fasilitas_id);

        $barisPerbandingan = [];

        $barisPerbandingan['K1'] = $k1;

        foreach ($penilaian as $p) {
            $barisPerbandingan['K' . $p->kriteria_id] = $p->nilai;
        }

        return $barisPerbandingan;
    }

    public function hitungTotalPelapor($fasilitas_id)
    {
        $laporan = LaporanModel::where('fasilitas_id', $fasilitas_id)
            ->distinct('no_induk')
            ->count('no_induk');

        return $laporan;
    }

    public function operasiMABAC()
    {
        $alternatif = AlternatifModel::with('laporan.fasilitas')->get();
        if ($alternatif->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Isikan Tabel Alternatif Terlebih Dahulu'
            ]);
        }

        $namaFasilitas = [];
        foreach ($alternatif as $alt) {
            $fasilitas = $alt->laporan->fasilitas->nama_fasilitas ?? 'Nama Fasilitas Tidak Diketahui';
            $namaFasilitas[$alt->alternatif_id] = $fasilitas;
        }

        $mabac = new MabacService();

        $penilaian = PenilaianModel::all();

        $tabelKeputusan = [];

        foreach ($penilaian->groupBy('alternatif_id') as $alternatif_id => $data) {
            $tabelKeputusan[] = [
                'alternatif_id' => $alternatif_id,
                'nilai' => $this->ambilBarisPenilaian($alternatif_id)
            ];
        }

        $hasil_rank = $mabac->prosesMabac($tabelKeputusan);

        session(['hasilRekomendasi' => $hasil_rank]);
        return view('admin.prioritas.step', ['hasil' => $hasil_rank, 'namaFasilitas' => $namaFasilitas]);
    }

    public function deploy_tech()
    {
        $alternatif = AlternatifModel::with('laporan.fasilitas')->get();
        $periode = PeriodeModel::all();
        $hasilRekomendasi = session('hasilRekomendasi');

        $namaFasilitas = [];
        foreach ($alternatif as $alt) {
            $fasilitas = $alt->laporan->fasilitas->nama_fasilitas ?? 'Nama Fasilitas Tidak Diketahui';
            $namaFasilitas[$alt->alternatif_id] = $fasilitas;
        }

        return view('admin.prioritas.deploy', ['hasil' => $hasilRekomendasi, 'namaFasilitas' => $namaFasilitas, 'periode' => $periode]);
    }

    public function deploy_store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if (!$request->has('arr_rekomendasi')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Field arr_rekomendasi tidak ditemukan dalam request.'
                ]);
            }

            try {
                $data = json_decode($request->input('arr_rekomendasi'), true);

                foreach ($data as $item) {
                    if (!isset($item['alternatif_id'], $item['ranking'], $item['nilai_q'])) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Format data salah'
                        ]);
                    } else {
                        $alternatif = AlternatifModel::with('laporan.fasilitas')->where('alternatif_id', $item['alternatif_id'])->first();
                        RekomendasiModel::create([
                            'alternatif_id' => $item['alternatif_id'],
                            'nilai_akhir' => $item['nilai_q'],
                            'ranking' => $item['ranking'],
                            'periode_id' => $request->input('periode'),
                        ]);
                        LaporanModel::where('fasilitas_id', $alternatif->laporan->fasilitas->fasilitas_id)->where('status_acc', 'disetujui')->whereNull('status_perbaikan')->update([
                            'status_perbaikan' => 'diproses'
                        ]);
                        PenilaianModel::truncate();
                    }
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data Rekomendasi Berhasil Tersimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak berhasil memproses data'
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Bukan merupakan json'
        ]);
    }
}
