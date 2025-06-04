<form action="{{ url('admin/prioritas/store-alternatif') }}" method="POST" class="space-y-4 font-inter" id="tambah-alternatif">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tambah Data Alternatif
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Pilih Laporan</label>
                <select name="laporan_id" id="laporan_id" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none" data-url="{{url('admin/prioritas/get-laporan')}}" required>
                    <option value="">Pilih Laporan</option>
                    @foreach ($pelaporan as $p)
                        <option value="{{ $p->laporan_id }}">{{ $p->kode_laporan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Nama Fasilitas</label>
                <h1 id="nama_fasilitas" class=" rounded w-full text-D_grey p-2 outline-none bg-gray-200">
                    Pilih Laporan
                </h1>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Gedung</label>
                <h1 id="gedung_nama" class=" rounded w-full text-D_grey p-2 outline-none bg-gray-200">
                    Pilih Laporan
                </h1>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Lantai</label>
                <h1 id="lantai_nama" class=" rounded w-full text-D_grey p-2 outline-none bg-gray-200">
                    Pilih Laporan
                </h1>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Ruangan</label>
                <h1 id="ruangan_kode" class=" rounded w-full text-D_grey p-2 outline-none bg-gray-200">
                    Pilih Laporan
                </h1>
            </div>
            <hr class="opacity-15 my-4">
            <label class="block mb-3 font-semibold text-green-700">KRITERIA</label>

            <div class="form-group">
                <label class="block mb-1 font-semibold">Skala Kerusakan</label>
                <select name="K2" id="K2" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none" required>
                    <option value="">Sedikit Rusak 1 - 5 Sangat Rusak</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <label class="block mb-1 font-semibold">Dampak Pada Pembelajaran</label>
                <select name="K3" id="K3" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none" required>
                    <option value="">Tidak Terlalu Signifikan 1 - 5 Sangat Signifikan</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Estimasi Biaya Perbaikan</label>
                <input type="number" id="K4" name="K4" placeholder="1000000" class="w-full border border-green-200 rounded p-2 outline-none" required>
            </div>
            <div class="form-group">
                <label class="block mb-1 font-semibold">Urgensi Perbaikan</label>
                <select name="K5" id="K5" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none" required>
                    <option value="">Tidak Terlalu Signifikan 1 - 5 Sangat Signifikan</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">Tambah</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#laporan_id').on('change', function () {
            let laporan_id = $(this).val();
            let base_url = $(this).data('url');
            $('h1').removeClass("bg-gray-200");
            $('h1').addClass("border-1 border-green-200");

            if (laporan_id) {
                $.get(`${base_url}/${laporan_id}`, function(response) {
                    if (response.status) {
                        $('#nama_fasilitas').text(response.data.nama_fasilitas);
                        $('#gedung_nama').text(response.data.gedung_nama);
                        $('#lantai_nama').text(response.data.lantai_nama);
                        $('#ruangan_kode').text(response.data.ruangan_kode);
                    } else {
                        $('#nama_fasilitas, #gedung_nama, #lantai_nama, #ruangan_kode').text('Data tidak ditemukan');
                    }
                });
            } else {
                $('#nama_fasilitas, #gedung_nama, #lantai_nama, #ruangan_kode').text('Pilih Laporan');
                $('h1').addClass("bg-gray-200");
                $('h1').removeClass("border-1 border-green-200");
            }
        });
    });


    function initTambahValidasi() {  
        if (typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate belum ter-load!");
            return;
        }

        const form = $("#tambah-alternatif");
        if (form.length === 0) {
            console.error("Form #tambah-alternatif tidak ditemukan di DOM.");
            return;
        }

        form.validate({
            rules: {
                laporan_id: {
                    required: true,
                    number: true
                },
                K2: {
                    required: true,
                    number: true,
                    max: 5
                },
                K3: {
                    required: true,
                    number: true,
                    max: 5
                },
                K4: {
                    required: true,
                    number: true,
                    max: 18446744073709551615
                },
                K5: {
                    required: true,
                    number: true,
                    max: 5
                },
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
                            dataKriteria.ajax.reload();
                            dataAlternatif.ajax.reload();
                            dataPenilaian.ajax.reload();
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
                $('h1').removeClass('border-1 border-green-200');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $('h1').addClass('border-1 border-green-200');
            }
        });
    }
</script>