@empty($periode)
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
                <a href="{{ url('/admin/periode') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{url('/admin/periode/'. $periode->periode_id . '/confirm')}}" method="POST" id=form-delete>
        @csrf
        @method('DELETE')
        <div class="space-y-6">
            <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
                Hapus Data Periode
            </div>
            <div class="p-5 flex flex-col justify-center gap-6">
                <div class="p-5 bg-warning text-blackshade1 rounded space-y-3">
                    <div class="flex space-x-5 items-center">
                        <i class="fa-solid fa-ban "></i>
                        <h1 class="font-semibold">KONFIRMASI!!!</h1>
                    </div>
                    <p>Apakah Anda ingin menghapus data seperti di bawah ini?</p>
                </div>
                <div class="mx-auto space-y-3">
                    <table class="table-auto min-w-max  divide-y divide-gray-200 text-sm text-left text-gray-700" id="table_fasilitas">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                            <tr class="table-row">
                                <th class="px-5 py-3">Nama periode</th>
                                <th class="px-5 py-3">Tanggal Mulai</th>
                                <th class="px-5 py-3">Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-5 py-4 whitespace-nowrap">{{$periode->nama_periode ?? '-'}} </td>
                                <td class="px-5 py-4 whitespace-nowrap">{{$periode->tanggal_mulai ?? '-' }} </td>
                                <td class="px-5 py-4 whitespace-nowrap">{{$periode->tanggal_selesai ?? '-' }} </td>
                            </tr>
                        </tbody>
                    </table>
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
@endempty

