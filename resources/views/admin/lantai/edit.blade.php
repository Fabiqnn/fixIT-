<form action="{{ url('admin/lantai/'. $lantai->id_lantai .'/update') }}" method="POST" class="space-y-4 font-inter" id="edit-lantai">
    @csrf
    @method('PUT')
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Edit Data Lantai
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Nama Lantai</label>
                <input type="text" name="nama_lantai"
                    class="w-full border border-green-200 rounded p-2 outline-none text-D_grey"
                    placeholder="Nama Lantai" value="{{ $lantai->nama_lantai ?? '-' }}" required >
            </div>
            <div>
                <label class="block mb-1 font-semibold">Gedung</label>
                <select name="gedung_id" id="gedung_id" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none" required>
                    @foreach ($gedung as $g)
                        <option {{$g->gedung_id == $lantai->gedung->gedung_id ? 'selected' : ''}} value="{{$g->gedung_id}}">{{$g->gedung_nama}} </option>   
                    @endforeach
                </select>
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

        const form = $("#edit-lantai");
        if (form.length === 0) {
            console.error("Form #edit-fasilitas tidak ditemukan di DOM.");
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