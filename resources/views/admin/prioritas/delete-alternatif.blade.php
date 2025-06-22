@empty($penilaian)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/admin/prioritas') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/admin/prioritas/' . $firstPenilaian->alternatif_id . '/delete-confirm') }}" method="POST"
        id=form-delete>
        @csrf
        @method('DELETE')
        <div class="space-y-6">
            <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
                Hapus Data Alternatif dan Penilaian Kriteria
            </div>
            <div class="p-5 flex flex-col justify-center gap-6">
                <div class="p-5 bg-warning text-blackshade1 rounded space-y-3">
                    <div class="flex space-x-5 items-center">
                        <i class="fa-solid fa-ban "></i>
                        <h1 class="font-semibold">KONFIRMASI!!!</h1>
                    </div>
                    <p>Apakah Anda ingin menghapus data sebagai berikut?</p>
                </div>
                <div class="space-y-3 mb-3">
                    <div>
                        <label class="block mb-1 font-semibold">Kode Laporan</label>
                        <div class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                            <h1>{{ $firstPenilaian->alternatif && $firstPenilaian->alternatif->laporan ? $firstPenilaian->alternatif->laporan->kode_laporan : '-' }}
                            </h1>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Nama Fasilitas</label>
                        <h1 id="nama_fasilitas"
                            class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                            {{ $firstPenilaian->alternatif &&
                            $firstPenilaian->alternatif->laporan &&
                            $firstPenilaian->alternatif->laporan->fasilitas
                                ? $firstPenilaian->alternatif->laporan->fasilitas->nama_fasilitas
                                : '-' }}
                        </h1>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Gedung</label>
                        <h1 id="gedung_nama" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                            {{ $firstPenilaian->alternatif &&
                            $firstPenilaian->alternatif->laporan &&
                            $firstPenilaian->alternatif->laporan->fasilitas &&
                            $firstPenilaian->alternatif->laporan->fasilitas->ruangan->gedung
                                ? $firstPenilaian->alternatif->laporan->fasilitas->ruangan->gedung->gedung_nama
                                : '-' }}
                        </h1>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Lantai</label>
                        <h1 id="lantai_nama" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                            {{ $firstPenilaian->alternatif &&
                            $firstPenilaian->alternatif->laporan &&
                            $firstPenilaian->alternatif->laporan->fasilitas &&
                            $firstPenilaian->alternatif->laporan->fasilitas->ruangan->lantai
                                ? $firstPenilaian->alternatif->laporan->fasilitas->ruangan->lantai->nama_lantai
                                : '-' }}
                        </h1>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Ruangan</label>
                        <h1 id="ruangan_kode" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                            {{ $firstPenilaian->alternatif &&
                            $firstPenilaian->alternatif->laporan &&
                            $firstPenilaian->alternatif->laporan->fasilitas &&
                            $firstPenilaian->alternatif->laporan->fasilitas->ruangan
                                ? $firstPenilaian->alternatif->laporan->fasilitas->ruangan->kode_ruangan
                                : '-' }}
                        </h1>
                    </div>
                    <hr class="opacity-15 my-4">
                    <label class="block mb-3 font-semibold text-green-700">KRITERIA</label>

                    <div class="form-group">
                        <label class="block mb-1 font-semibold">Skala Kerusakan</label>
                        <h1 name="K2" id="K2"
                            class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                            {{ $nilaiLama['K2'] }}
                        </h1>
                    </div>
                    <div class="form-group">
                        <label class="block mb-1 font-semibold">Dampak Pada Pembelajaran</label>
                        <h1 name="K3" id="K3"
                            class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                            {{ $nilaiLama['K3'] }}
                        </h1>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Estimasi Biaya Perbaikan</label>
                        <h1 id="K4" name="K4" class="w-full border border-green-200 rounded p-2 outline-none">
                            {{ $nilaiLama['K4'] }}
                        </h1>
                    </div>
                    <div class="form-group">
                        <label class="block mb-1 font-semibold">Urgensi Perbaikan</label>
                        <h1 name="K5" id="K5"
                            class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none">
                            {{ $nilaiLama['K5'] }}
                        </h1>
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="button-warning" onclick="closeModal()">Batal</button>
                    <button type="submit" class="button-info">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        function initDeleteValidasi() {
            $("#form-delete").validate({
                rules: {},
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
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        }
    </script>
@endempty
