<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModels;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use App\Models\ProdiModel;
use App\Models\JurusanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;





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
    public function list(Request $request)
    {
        $user = UserModels::select('user_id', 'nama_lengkap', 'level_id', 'email', 'nomor_telp')
            ->with('level');

        return DataTables::of($user)
            ->addIndexColumn()

            ->addColumn('level_nama', function ($item) {
                return $item->level->level_nama ?? '-';
            })

            ->addColumn('aksi', function ($item) {
                return '
            <div class="flex justify-end gap-2">
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/show') . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/edit_ajax') . '\')" class="px-3 py-1 button1 cursor-pointer">Edit</button>
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/delete_ajax') . '\')" class="px-3 py-1 button-error cursor-pointer">Hapus</button>
            </div>
            ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function list_user(Request $request)
    {
        $user = UserModels::select('user_id', 'nama_lengkap', 'level_id', 'email', 'nomor_telp')
            ->with('level');

        return DataTables::of($user)
            ->addIndexColumn()

            ->addColumn('level_nama', function ($item) {
                return $item->level->level_nama ?? '-';
            })

            ->addColumn('aksi', function ($item) {
                return '
            <div class="flex justify-end gap-2">
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/show') . '\')" class="px-3 py-1 button-info cursor-pointer">Detail</button>
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/edit_ajax') . '\')" class="px-3 py-1 button1 cursor-pointer">Edit</button>
                <button onclick="modalAction(\'' . url('/admin/user/' . $item->user_id . '/delete_ajax') . '\')" class="px-3 py-1 button-error cursor-pointer">Hapus</button>
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

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username' => 'required|string|min:3|unique:table_users,username,' . $id . ',user_id',
                'nama_lengkap' => 'required|string|max:100',
                'level_id' => 'required|integer',
                'jurusan_id' => 'required|integer',
                'prodi_id' => 'required|integer',
                'email' => 'nullable|email|max:100',
                'nomor_telp' => 'nullable|string|max:15',
                'nip' => 'nullable|string|max:30',
                'nim' => 'nullable|string|max:30',
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

            $user = UserModels::find($id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $data = $request->only([
                'username',
                'nama_lengkap',
                'email',
                'nomor_telp',
                'nip',
                'nim',
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
                'message' => 'Data user berhasil diupdate'
            ]);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:table_users,username',
                'password' => 'required|min:6',
                'nama_lengkap' => 'required|string|max:100',
                'level_id' => 'required|integer',
                'jurusan_id' => 'required|integer',
                'prodi_id' => 'required|integer',
                'email' => 'nullable|email|max:100',
                'nomor_telp' => 'nullable|string|max:15',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            UserModels::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'nomor_telp' => $request->nomor_telp,
                'nip' => $request->nip,
                'nim' => $request->nim,
                'level_id' => $request->level_id,
                'jurusan_id' => $request->jurusan_id,
                'prodi_id' => $request->prodi_id
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
