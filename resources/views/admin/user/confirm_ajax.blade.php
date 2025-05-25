@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" onclick="closeModal()"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data user tidak ditemukan.
                </div>
                <button class="btn btn-warning" onclick="closeModal()">Kembali</button>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/admin/user/' . $user->user_id . '/delete_ajax') }}" method="POST" id="form-delete-user">
        @csrf
        @method('DELETE')
        <div class="space-y-6">
            <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
                Hapus User
            </div>
            <div class="p-5 flex flex-col justify-center gap-6">
                <div class="p-5 bg-warning text-blackshade1 rounded space-y-3">
                    <div class="flex space-x-5 items-center">
                        <i class="fa-solid fa-ban"></i>
                        <h1 class="font-semibold">KONFIRMASI!!!</h1>
                    </div>
                    <p>Apakah Anda yakin ingin menghapus user berikut?</p>
                </div>
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 border-collapse" id="tableUser">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3">Nama Lengkap</th>
                                <th class="px-6 py-3">Username</th>
                                <th class="px-6 py-3">Level</th>
                                <th class="px-6 py-3">Email</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">{{ $user->nama_lengkap ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $user->username ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $user->level->level_nama ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $user->email ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="button-warning" onclick="closeModal()">Batal</button>
                    <button type="submit" class="button-info">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        function initDeleteValidasi() {
            $('#form-delete-user').validate({
                rules: {},
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                closeModal();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataUser.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus user.'
                            });
                        }
                    });
                    return false;
                }
            });
        }
    </script>
@endempty
