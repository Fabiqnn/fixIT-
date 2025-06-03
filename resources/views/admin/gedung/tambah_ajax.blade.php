<form action="{{ url('/admin/gedung/store') }}" method="POST" id="tambah-gedung" class="space-y-4 font-inter">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tambah Gedung
        </div>
        <div class="p-6 space-y-3">
            <div class="form-group">
                <label class="block mb-1 font-semibold">Nama Gedung</label>
                <input type="text" name="gedung_nama" class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="Contoh: T.Sipil, T.Mesin, AJ">
                <span id="error-gedung_nama" class="text-red-500 text-sm block mt-1"></span>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">
                    Tambah
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    function initTambahValidasi() {
        if (typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate belum dimuat!");
            return;
        }

        const form = $("#tambah-gedung");
        if (form.length === 0) {
            console.error("Form #tambah-gedung tidak ditemukan.");
            return;
        }

        form.validate({
            rules: {
                gedung_nama: {
                    required: true,
                    maxlength: 100
                }
            },
            messages: {
                gedung_nama: {
                    required: "Nama gedung wajib diisi.",
                    maxlength: "Maksimal 100 karakter."
                }
            },
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
                            $('#error-gedung_nama').text(response.message);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                $('#error-' + field).text(messages[0]);
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: 'Harap periksa kembali input Anda.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal menambahkan data.'
                            });
                        }
                    }
                });

                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                const id = element.attr('name');
                $('#error-' + id).text(error.text());
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    }
</script>
