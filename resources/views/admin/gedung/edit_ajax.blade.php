<form action="{{ url('/admin/building/update_ajax/' . $gedung->gedung_id) }}" method="POST"
    id="form-edit"class="space-y-4 font-inter">
    @csrf
    @method('PUT')
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Edit Gedung
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Nama Gedung</label>
                <input type="text" name="gedung_nama" value="{{ $gedung->gedung_nama }}"
                    class="w-full border border-green-700 rounded p-2 outline-none"
                    placeholder="Contoh: T.Sipil, T.Mesin, AJ" required>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        $(document).ready(function() {
            $('#form-edit').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                $('#modalContainer').addClass('hidden');
                                $('#modalContent').html('');
                                dataGedung.ajax
                                    .reload();
                            });
                        } else {
                            let msg = response.message;
                            if (response.msgField) {
                                msg = Object.values(response.msgField).map(e => e[0]).join(
                                    '\n');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: msg
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Data gagal diperbarui'
                        });
                    }
                });
            });
        });
    </script>
@endpush
