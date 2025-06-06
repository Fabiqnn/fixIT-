<form action="{{ url('admin/lantai/store') }}" method="POST" class="space-y-4 font-inter" id="tambah-lantai">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tambah Data lantai
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Nama Lantai</label>
                <input type="text" name="nama_lantai" id="nama_lantai"
                    class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="Nama Lantai" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Gedung</label>
                <select name="gedung_id" id="gedung_id" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none" required>
                    <option value="">- Pilih Gedung -</option>
                    @foreach ($gedung as $g)
                        <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                    @endforeach
                </select>
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

        const form = $("#tambah-lantai");
        if (form.length === 0) {
            console.error("Form #tambah-lantai tidak ditemukan di DOM.");
            return;
        }

        form.validate({
            rules: {
                nama_lantai: {
                    required: true,
                    maxlength: 50
                },
                gedung_id: {
                    required: true,
                    number: true
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
                            dataLantai.ajax.reload();
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