<form action="{{ url('admin/periode/store') }}" method="POST" class="space-y-4 font-inter" id="tambah-periode">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tambah Data Periode
        </div>
        <div class="p-6 space-y-3">
            <div class="form-group">
                <label class="block mb-1 font-semibold">Nama Lantai</label>
                <input type="text" name="nama_periode" id="nama_periode"
                    class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="Januari 2025" required>
            </div>
            <div class="form-group">
                <label class="block mb-1 font-semibold">Tanngal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                    class="w-full border border-green-200 rounded p-2 outline-none" required>
            </div>
            <div class="form-group">
                <label class="block mb-1 font-semibold">Tanngal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                    class="w-full border border-green-200 rounded p-2 outline-none" required>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">Tambah</button>
            </div>
        </div>
    </div>
</form>
<script>
    function initTambahValidasi() {  
        if (typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate belum ter-load!");
            return;
        }

        const form = $("#tambah-periode");
        if (form.length === 0) {
            console.error("Form #tambah-periode tidak ditemukan di DOM.");
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