<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\UserModels;
use Illuminate\Http\Request;
use App\Models\JurusanModel;
use App\Models\ProdiModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profile.profile', compact('user'));
    }

    public function edit_ajax($id)
    {
        $user = UserModels::find($id);
        $jurusan = JurusanModel::select('jurusan_id', 'jurusan_nama')->get();
        $prodi = ProdiModel::select('prodi_id', 'prodi_nama')->get();
        $role = LevelModel::select('level_id', 'level_nama')->get();

        return view('admin.user.edit_ajax', ['user' => $user, 'jurusan' => $jurusan, 'prodi' => $prodi, 'level' => $role]);
    }

    public function update_ajax(Request $request, $no_induk)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $MAHASISWA_LEVEL_ID = 3;

            $rules = [
                'nama_lengkap' => 'required|string|max:100',
                'level_id' => 'required|integer',
                'email' => 'nullable|email|max:100',
                'nomor_telp' => 'nullable|string|max:15',
            ];

            if ((int) $request->level_id === $MAHASISWA_LEVEL_ID) {
                $rules['jurusan_id'] = 'required|integer';
                $rules['prodi_id'] = 'required|integer';
            }

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
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $data = $request->only([
                'nama_lengkap',
                'email',
                'nomor_telp',
                'level_id',
                'jurusan_id',
                'prodi_id'
            ]);

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil diperbarui'
            ]);
        }
    }
}
