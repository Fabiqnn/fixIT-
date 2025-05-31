<form action="{{ url('admin/pelaporan/'. $pelaporan->laporan_id .'/update') }}" method="POST" class="space-y-4 font-inter" id="edit-fasilitas">
    @csrf
    @method('PUT')
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            edit Data Fasilitas
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Deskripsi</label>
                <input type="text" name="deskripsi_kerusakan"
                    class="w-full border border-green-200 rounded p-2 outline-none text-D_grey"
                    placeholder="Deskripsi" value="{{ $pelaporan->deskripsi_kerusakan ?? '-' }}" required >
            </div>
            <div class="flex justify-end mt-6 space-x-3">
                <button type="button" class="button-warning" onclick="closeModal()">Batal</button>
                <button type="submit" class="button-info">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>

    function initEditValidasi() { 
        if (typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate belum ter-load!");
            return;
        }

        const form = $("#edit-fasilitas");
        if (form.length === 0) {
            console.error("Form #edit-fasilitas tidak ditemukan di DOM.");
            return;
        }

        form.validate({
            rules: {
                deskripsi_kerusakan: {
                    required: true,
                    maxlength: 200
                }
            },
            submitHandler: function(form) {
                console.log("Validasi")
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
                            dataPelaporan.ajax.reload();
                            dataPelaporanAcc.ajax.reload();
                            dataPelaporanDec.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    }
</script>