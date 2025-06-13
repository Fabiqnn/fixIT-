<form action="{{ url('admin/fasilitas/'. $fasilitas->fasilitas_id .'/update') }}" method="POST" class="space-y-4 font-inter" id="edit-fasilitas">
    @csrf
    @method('PUT')
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            edit Data Fasilitas
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Nama Fasilitas</label>
                <input type="text" name="nama_fasilitas"
                    class="w-full border border-green-200 rounded p-2 outline-none text-D_grey"
                    placeholder="Nama Fasilitas" value="{{ $fasilitas->nama_fasilitas ?? '-' }}" required >
            </div>
            <div>
                <label class="block mb-1 font-semibold">Kode Fasilitas</label>
                <input type="text" name="kode_fasilitas" class="w-full border border-green-200 rounded p-2 outline-none text-D_grey"
                    placeholder="Kode" value="{{ $fasilitas->kode_fasilitas ?? '-' }}" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Gedung</label>
                <select name="id_gedung" id="id_gedung" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none"  data-url="{{url('admin/fasilitas/get-lantai')}}" required>
                    @foreach ($gedung as $g)
                        <option {{$g->gedung_id == $fasilitas->ruangan->gedung->gedung_id ? 'selected' : ''}} value="{{$g->gedung_id}}">{{$g->gedung_nama}} </option>   
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Lantai</label>
                <select name="id_lantai" id="id_lantai" class=" rounded w-full text-D_grey p-2 outline-none bg-gray-200"  data-url="{{url('admin/fasilitas/get-ruangan')}}" required disabled>
                    @foreach ($lantai as $l)
                        <option {{$l->id_lantai == $fasilitas->ruangan->lantai->id_lantai ? 'selected' : ''}} value="{{$l->id_lantai}}">{{$l->nama_lantai}} </option>   
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Ruangan</label>
                <select name="ruangan_id" id="ruangan_id" class=" rounded w-full text-D_grey p-2 outline-none bg-gray-200" required disabled>
                    @foreach ($ruangan as $r)
                        <option {{$r->id_ruangan == $fasilitas->ruangan->id_ruangan ? 'selected' : ''}} value="{{$r->id_ruangan}}">{{$r->kode_ruangan}} </option>   
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tanggal_pengadaan" class="block mb-1 font-semibold">Tanggal Pengadaan</label>
                <input type="date" id="tanggal_pengadaan" name="tanggal_pengadaan" class="w-full border border-green-200 rounded p-2 outline-none text-D_grey" value="{{$fasilitas->tanggal_pengadaan ?? '-'}}">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Status Fasilitas</label>
                <select name="status" id="status" name="status" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                    <option {{$fasilitas->status == 'baik' ? 'selected' : ''}} value="baik">Baik</option>
                    <option {{$fasilitas->status == 'rusak' ? 'selected' : ''}} value="rusak">Rusak</option>
                    <option {{$fasilitas->status == 'dalam perbaikan' ? 'selected' : ''}} value="dalam perbaikan">Dalam Perbaikan</option>
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
    $(document).ready(function() {
        $('#id_gedung').on('change', function () {
            let gedung_id = $(this).val();
            let base_url = $(this).data('url');
            $('#id_lantai').prop('disabled', true).html('<option>Loading...</option>');
            $('#id_ruangan').prop('disabled', true).html('<option>Pilih Ruangan</option>');
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

        $('#id_lantai').on('change', function () {
            let id_lantai = $(this).val();
            let base_url = $(this).data('url');
            $('#ruangan_id').prop('disabled', true).html('<option>Loading...</option>');
            $('#ruangan_id').removeClass("bg-gray-300");
            $('#ruangan_id').addClass("border-1 border-green-200");

            if (id_lantai) {
                $.get(`${base_url}/${id_lantai}`, function (data) {
                    $('#ruangan_id').empty().append('<option value="">Pilih Ruangan</option>');
                    $('#ruangan_id').removeClass("bg-gray-300");
                    $('#ruangan_id').addClass("border-1 border-green-200");
                    $.each(data, function (key, value) {
                        $('#ruangan_id').append(`<option value="${value.id_ruangan}">${value.kode_ruangan}</option>`);
                    });
                    $('#ruangan_id').prop('disabled', false);
                });
            }
        });
    });

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
                nama_fasilitas: {
                    required: true,
                    maxlength: 50
                },
                kode_fasilitas: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                ruangan_id: {
                    required: true,
                    number: true
                },
                tanggal_pengadaan: {
                    required: true,
                    date: true
                }, 
                status: {
                    required: true,
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
                            dataFasilitas.ajax.reload();
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