<form action="{{ url('admin/ruangan/store') }}" method="POST" class="space-y-4 font-inter" id="tambah-ruangan">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tambah Data Ruangan
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Nama Ruangan</label>
                <input type="text" name="kode_ruangan" id="kode_ruangan"
                    class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="R301" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Gedung</label>
                <select name="id_gedung" id="id_gedung" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none" data-url="{{url('admin/ruangan/get-lantai')}}" required>
                    <option value="">Pilih Gedung</option>
                    @foreach ($gedung as $g)
                        <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Lantai</label>
                <select name="id_lantai" id="id_lantai" class="rounded w-full text-D_grey p-2 outline-none bg-gray-200" required disabled>
                    <option value="">Pilih Lantai</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan"
                    class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="Keterangan" required>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">Tambah</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $('#id_gedung').on('change', function () {
            let gedung_id = $(this).val();
            let base_url = $(this).data('url');
            $('#id_lantai').prop('disabled', true).html('<option>Loading...</option>');
            $('#id_lantai').removeClass("bg-gray-200");
            $('#id_lantai').addClass("border-1 border-green-200");
            
            if (gedung_id) {
                $.get(`${base_url}/${gedung_id}`, function (data) {
                    $('#id_lantai').empty().append('<option value="">Pilih Lantai</option>');
                    $('#id_lantai').removeClass("bg-gray-200");
                    $('#id_lantai').addClass("border-1 border-green-200");
                    $.each(data, function (key, value) {
                        $('#id_lantai').append(`<option value="${value.id_lantai}">${value.nama_lantai}</option>`);
                    });
                    $('#id_lantai').prop('disabled', false);
                });
            }
        });
    });

    function initTambahValidasi() {
        if (typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate belum ter-load!");
            return;
        }

        const form = $("#tambah-ruangan");
        if (form.length === 0) {
            console.error("Form #tambah-ruangan tidak ditemukan di DOM.");
            return;
        }

        form.validate({
            rules: {
                kode_ruangan: {
                    required: true,
                    maxlength: 50
                },
                id_gedung: {
                    required: true,
                    number: true
                },
                id_lantai: {
                    required: true,
                    number: true
                },
                keterangan: {
                    required: false,
                    maxlength: 100
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
                            dataRuangan.ajax.reload();
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