@empty($pelaporan)
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
                <a href="{{ url('/admin/pelaporan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{url('/admin/pelaporan/'. $pelaporan->laporan_id . '/up_acc')}}" method="POST" id=form-acc>
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
                Hapus Data Lantai
            </div>
            <div class="p-5 flex flex-col justify-center gap-6">
                <div class="p-5 bg-info text-blackshade1 rounded space-y-3">
                    <div class="flex space-x-5 items-center">
                        <i class="fa-solid fa-ban "></i>
                        <h1 class="font-semibold">KONFIRMASI!!!</h1>
                    </div>
                    <p>Apakah Anda ingin memvalidasi data seperti di bawah ini?</p>
                </div>
                <div class="space-y-3 mb-3">
                    <div class="space-y-5">
                        <label class="font-semibold">Nama Fasilitas</label>
                        <div class="p-3 w-full border border-success rounded">
                            <h1>{{$pelaporan->fasilitas->nama_fasilitas ?? '-'}} </h1>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <label class="font-semibold">Ruangan</label>
                        <div class="p-3 w-full border border-success rounded">
                            <h1>{{$pelaporan->fasilitas->ruangan->kode_ruangan ?? '-'}} </h1>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <label class="font-semibold">Lantai</label>
                        <div class="p-3 w-full border border-success rounded">
                            <h1>{{$pelaporan->fasilitas->ruangan->lantai->nama_lantai ?? '-'}} </h1>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <label class="font-semibold">Gedung</label>
                        <div class="p-3 w-full border border-success rounded">
                            <h1>{{$pelaporan->fasilitas->ruangan->gedung->gedung_nama ?? '-'}} </h1>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <label class="font-semibold">Tanggal Laporan</label>
                        <div class="p-3 w-full border border-success rounded">
                            <h1>{{$pelaporan->tanggal_laporan ?? '-'}} </h1>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <label class="font-semibold">Deskripsi Kerusakan</label>
                        <div class="p-3 w-full border border-success rounded">
                            <h1>{{$pelaporan->deskripsi_kerusakan ?? '-'}} </h1>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <label class="font-semibold">Foto Kerusakan</label>
                        <div class="p-3 w-full border border-success rounded min-h-30">
                            <h1>{{asset('') ?? '-'}} </h1>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <label class="font-semibold">Status Validasi</label>
                        <div class="p-3 w-full border border-success rounded">
                            <h1>{{$pelaporan->status_acc ?? '-'}} </h1>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="button-warning" onclick="closeModal()">Batal</button>
                    <button type="submit" class="button-info">Ya, Terima</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        function initAccValidasi() {
            $("#form-acc").validate({
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
                                dataPelaporanPending.ajax.reload();
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
@endempty

