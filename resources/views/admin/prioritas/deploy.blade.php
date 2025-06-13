<form action="{{ url('/admin/prioritas/deploy') }}" method="POST" id="form-tugas">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tugaskan Data Proritas
        </div>
        <div class="p-5 flex flex-col justify-center gap-6">
            <div class="p-5 bg-warning text-blackshade1 rounded space-y-3">
                <div class="flex space-x-5 items-center">
                    <i class="fa-solid fa-ban"></i>
                    <h1 class="font-semibold">KONFIRMASI!!!</h1>
                </div>
                <p>Apakah Anda yakin ingin menugaskan data prioritas berikut ke teknisi? <br> Tabel Penilaian dan Tabel
                    Alternatif yang telah diteruskan akan dihapus</p>
            </div>
            <div class="mx-auto space-y-3">
                <label class="font-semibold">Perangkingan</label>
                <div class="p-3 w-full border border-success rounded">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="text-D_grey font-semibold uppercase text-xs border-b-1">
                            <th class="px-3">Rangking</th>
                            <th class="px-3">Alternatif</th>
                            <th class="px-3">Nilai Q</th>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($hasil['rangking'] as $item)
                                <tr class="py-1">
                                    <td class="px-3">{{ $item['ranking'] }} </td>
                                    <td class="px-3">{{ $namaFasilitas[$item['alternatif_id']] }} </td>
                                    <td class="px-3">{{ $item['nilai_q'] }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Periode</label>
                    <select name="periode" id="periode" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none"  data-url="{{url('admin/fasilitas/get-lantai')}}" required>
                        <option value="">Pilih Periode</option>
                        @foreach ($periode as $p)
                            <option value="{{ $p->periode_id }}">{{ $p->nama_periode }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="arr_rekomendasi" id="arr_rekomendasi" value='@json($hasil['rangking'])'
                    hidden>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="button-warning" onclick="closeModal()">Batal</button>
                <button type="submit" class="button-info">Ya, Teruskan</button>
            </div>
        </div>
    </div>
</form>

<script>
    function initTugaskanValidasi() {
        $("#form-tugas").validate({
            rules: {
                periode: {
                    required: true,
                    date: true
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
                            dataKriteria.ajax.reload();
                            dataAlternatif.ajax.reload();
                            dataPenilaian.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal meneruskan data ke Teknisi'
                        });
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        const id = element.attr('name');
                        $('#error-' + id).text(error.text());
                    },
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid');
                    }
                });
                return false;
            }
        });
    }
</script>
