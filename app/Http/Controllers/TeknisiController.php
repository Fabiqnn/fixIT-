<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanModel;
use Yajra\DataTables\Facades\DataTables;



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

    public function sedangDiproses()
    {
        $page = (object) [
            'title' => 'Tugas Diproses',
            'header' => 'Tugas Diproses'
        ];

        $activeMenu = 'tugasDiproses';
        return view('teknisi.tugas_diproses', ['page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function selesai()
    {
        $page = (object) [
            'title' => 'Tugas Diproses',
            'header' => 'Tugas Diproses'
        ];

        $activeMenu = 'selesai';
        return view('teknisi.tugas_selesai', ['page' => $page, 'activeMenu' => $activeMenu]);
    }


    public function list_diproses(Request $request)
    {
        $query = LaporanModel::with('fasilitas.ruangan.gedung')
            ->where('status_perbaikan', 'diproses');

        if ($request->has('status_perbaikan') && $request->status_perbaikan != '') {
            $query->where('status_perbaikan', $request->status_perbaikan);
        }

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('fasilitas_nama', function ($row) {
                return $row->fasilitas->nama_fasilitas ?? '-';
            })

            ->addColumn('gedung_nama', function ($row) {
                return $row->fasilitas->ruangan->gedung->gedung_nama ?? '-';
            })

            ->addColumn('aksi', function ($row) {
                $detailBtn = '<button onclick="modalAction(\'' . url('/teknisi/list_diproses/' . $row->laporan_id . '/show') . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>';
                $konfirmasiBtn = '<button onclick="modalAction(\'' . url('/teknisi/laporan/' . $row->laporan_id . '/confirm_tuntas') . '\')" class="px-3 py-1 button2 bg-green-600 text-white hover:bg-green-700 cursor-pointer">Update</button>';

                return '
        <div class="flex justify-end gap-2">
            ' . $detailBtn . '
            ' . $konfirmasiBtn . '
        </div>
    ';
            })


            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function list_selesai(Request $request)
    {
        $query = LaporanModel::with('fasilitas.ruangan.gedung')
            ->where('status_perbaikan', 'tuntas');

        if ($request->has('status_perbaikan') && $request->status_perbaikan != '') {
            $query->where('status_perbaikan', $request->status_perbaikan);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('fasilitas_nama', function ($row) {
                return $row->fasilitas->nama_fasilitas ?? '-';
            })
            ->addColumn('gedung_nama', function ($row) {
                return $row->fasilitas->ruangan->gedung->gedung_nama ?? '-';
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
        $laporan = LaporanModel::findOrFail($id);
        return view('teknisi.confirm_ajax', compact('laporan'));
    }
    public function markTuntas($id)
    {
        $laporan = LaporanModel::findOrFail($id);

        if ($laporan->status_perbaikan !== 'diproses') {
            return response()->json(['success' => false, 'message' => 'Status tidak valid']);
        }

        $laporan->status_perbaikan = 'tuntas';
        $laporan->save();

        return response()->json(['success' => true]);
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
}
