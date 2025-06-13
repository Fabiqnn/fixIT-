<?php

namespace App\Http\Controllers\admin;

use App\Models\FasilitasModel;
use App\Models\LevelModel;
use App\Models\UserModels;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;




class AdminController extends Controller
{

    public function index()
    {
        $periodeData = DB::table('table_periode')
            ->orderBy('periode_id')
            ->get();

        $data = [];
        foreach ($periodeData as $periode) {
            $data[$periode->nama_periode] = ['tuntas' => 0, 'diproses' => 0];
        }

        $rows = DB::table('table_periode as p')
            ->leftJoin('table_rekomendasi as r', 'r.periode_id', '=', 'p.periode_id')
            ->leftJoin('table_alternatif as a', 'a.alternatif_id', '=', 'r.alternatif_id')
            ->leftJoin('table_laporan as l', 'l.laporan_id', '=', 'a.laporan_id')
            ->select('p.nama_periode', 'l.status_perbaikan', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('l.status_perbaikan')
            ->groupBy('p.nama_periode', 'l.status_perbaikan')
            ->get();

        foreach ($rows as $row) {
            $periode = $row->nama_periode;
            $status = strtolower($row->status_perbaikan);

            if (isset($data[$periode])) {
                $data[$periode][$status] = $row->jumlah;
            }
        }

        $labels = array_keys($data);
        $tuntas = array_column($data, 'tuntas');
        $diproses = array_column($data, 'diproses');

        $page = (object) [
            'title' => 'Dashboard',
            'header' => 'Status Perbaikan per Periode'
        ];

        $activeMenu = 'dashboard';

        return view('admin.dashboard', compact('labels', 'tuntas', 'diproses', 'page', 'activeMenu'));
    }


    public function profile()
    {
        $user = auth()->user();
        $activeMenu = '';
        return view('admin.profile.profile', compact('user'), ['activeMenu' => $activeMenu]);
    }

    public function edit_profile($id)
    {
        $user = UserModels::find($id);
        $role = LevelModel::select('level_id', 'level_nama')->get();

        return view('admin.profile.edit', ['user' => $user, 'level' => $role]);
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
