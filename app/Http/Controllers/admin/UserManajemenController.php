<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\UserModels;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use App\Models\ProdiModel;
use App\Models\JurusanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;




class UserManajemenController extends Controller
{
    public function user()
    {
        $page = (object) [
            'title' => 'User',
            'header' => 'User Management'
        ];

        $activeMenu = 'user';

        return view('admin.user.index', ['page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list_user(Request $request)
    {
        $user = UserModels::select('no_induk', 'nama_lengkap', 'level_id', 'email', 'nomor_telp')
            ->with('level');

        return DataTables::of($user)
            ->addIndexColumn()

            ->addColumn('level_nama', function ($item) {
                return $item->level->level_nama ?? '-';
            })

            ->addColumn('aksi', function ($item) {
                return '
        <div class="flex justify-end gap-2">
            <button onclick="modalAction(\'' . url('/admin/user/' . $item->no_induk . '/show') . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>
            <button onclick="modalAction(\'' . url('/admin/user/' . $item->no_induk . '/edit_ajax') . '\')" class="px-3 py-1 button1 cursor-pointer">Edit</button>
            <button onclick="modalAction(\'' . url('/admin/user/' . $item->no_induk . '/delete_ajax') . '\')" class="px-3 py-1 button-error cursor-pointer">Hapus</button>
        </div>
        ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function tambah_ajax()
    {
        $level = LevelModel::all();
        $jurusan = JurusanModel::all();
        $prodi = ProdiModel::all();

        return view('admin.user.tambah_ajax', compact('level', 'jurusan', 'prodi'));
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

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $MAHASISWA_LEVEL_ID = 3;

            $rules = [
                'no_induk' => 'required|string|max:20|unique:table_users,no_induk',
                'password' => 'required|string|min:6',
                'nama_lengkap' => 'required|string|max:255',
                'level_id' => 'required|integer',
                'email' => 'nullable|email|max:255',
                'nomor_telp' => 'nullable|string|max:15',
            ];

            if ((int) $request->level_id === $MAHASISWA_LEVEL_ID) {
                $rules['jurusan_id'] = 'required|integer';
                $rules['prodi_id'] = 'required|integer';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            UserModels::create([
                'no_induk' => $request->no_induk,
                'password' => bcrypt($request->password),
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'nomor_telp' => $request->nomor_telp,
                'level_id' => $request->level_id,
                'jurusan_id' => $request->jurusan_id ?? null,
                'prodi_id' => $request->prodi_id ?? null,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User berhasil ditambahkan'
            ]);
        }
    }


    public function confirm($id)
    {
        $user = UserModels::find($id);

        return view('admin.user.confirm_ajax', ['user' => $user]);
    }
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModels::find($id);
            if ($user) {
                $user->delete();
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
                'message' => 'Tidak Berupa ajax json'
            ]);
        }
    }

    public function show($id)
    {
        $user = UserModels::find($id);

        return view('admin.user.show', ['user' => $user]);
    }
}
