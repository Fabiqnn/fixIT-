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



class AdminController extends Controller
{
    public function index()
    {
        $page = (object) [
            'title' => 'Dashboard',
            'header' => 'Dashboard'
        ];

        $activeMenu = 'dashboard';

        return view('admin.dashboard', ['page' => $page, 'activeMenu' => $activeMenu]);
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
