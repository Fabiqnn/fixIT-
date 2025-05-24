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
            $("#form-edit").validate({
                rules: {
                    gedung_nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    }
                },
                messages: {
                    gedung_nama: {
                        required: "Nama gedung wajib diisi",
                        minlength: "Minimal 3 karakter",
                        maxlength: "Maksimal 100 karakter"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => {
                                    $('#modalContainer').addClass('hidden');
                                    $('#modalContent').html('');
                                    dataGedung.ajax.reload(); // reload DataTable
                                });
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
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
                                text: 'Data gagal diperbarui'
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
