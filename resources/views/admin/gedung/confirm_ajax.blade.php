@empty($gedung)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" onclick="closeModal()"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data gedung tidak ditemukan
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/admin/gedung/delete_ajax/' . $gedung->gedung_id) }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')

        <div class="space-y-6">
            <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
                Hapus Data Gedung
            </div>
            <div class="p-5 flex flex-col justify-center gap-6">
                <div class="p-5 bg-warning text-blackshade1 rounded space-y-3">
                    <div class="flex space-x-5 items-center">
                        <i class="fa-solid fa-ban"></i>
                        <h1 class="font-semibold">KONFIRMASI!!!</h1>
                    </div>
                    <p>Apakah Anda yakin ingin menghapus data gedung berikut ini?</p>
                </div>
                <div class="mx-auto space-y-3">
                    <table class="table-auto min-w-max divide-y divide-gray-200 text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3">Nama Gedung</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $gedung->gedung_nama ?? '-' }}</td>
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
            $("#form-delete").validate({
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
                                dataGedung.ajax.reload();
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
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal menghapus data.'
                            });
                        }
                    });
                    return false;
                }
            });
        }
    </script>
@endempty
