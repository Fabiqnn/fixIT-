<form action="{{ url('admin/periode/'. $periode->periode_id .'/update') }}" method="POST" class="space-y-4 font-inter" id="edit-periode">
    @csrf
    @method('PUT')
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Edit Data Periode
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Nama Periode</label>
                <input type="text" name="nama_periode"
                    class="w-full border border-green-200 rounded p-2 outline-none text-D_grey"
                    placeholder="Deskripsi" value="{{ $periode->nama_periode ?? '-' }}" required >
            </div>
            <div>
                <label class="block mb-1 font-semibold">Nama Periode</label>
                <input type="date" name="tanggal_mulai"
                    class="w-full border border-green-200 rounded p-2 outline-none text-D_grey"
                    placeholder="Deskripsi" value="{{ $periode->tanggal_mulai ?? '-' }}" required >
            </div>
            <div>
                <label class="block mb-1 font-semibold">Nama Periode</label>
                <input type="date" name="tanggal_selesai"
                    class="w-full border border-green-200 rounded p-2 outline-none text-D_grey"
                    placeholder="Deskripsi" value="{{ $periode->tanggal_selesai ?? '-' }}" required >
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

        const form = $("#edit-periode");
        if (form.length === 0) {
            console.error("Form #edit-periode tidak ditemukan di DOM.");
            return;
        }

        form.validate({
            rules: {
                nama_periode: {
                    required: true,
                    maxlength: 200
                },
                tanggal_mulai: {
                    required: true,
                    date: true
                },
                tanggal_selesai: {
                    required: true,
                    date: true
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
                            dataPeriode.ajax.reload();
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