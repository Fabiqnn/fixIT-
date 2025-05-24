<form action="{{ url('admin/fasilitas/store') }}" method="POST" class="space-y-4 font-inter" id="tambah-fasilitas">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tambah Pengguna
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Nama Fasilitas</label>
                <input type="text" name="nama_fasilitas"
                    class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="Nama Fasilitas" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Kode Fasilitas</label>
                <input type="text" name="kode_fasilitas" class="w-full border border-green-200 rounded p-2 outline-none "
                    placeholder="Kode" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Gedung</label>
                <select name="id_gedung" id="id_gedung" class="border-1 border-green-200 rounded w-full text-D_grey p-2 outline-none" required>
                    <option value="">- Pilih Gedung -</option>
                    @foreach ($gedung as $g)
                        <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition">Tambah</button>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        $(document).ready(function() {
            $('#tambah-fasilitas').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                $('#modalContainer').addClass('hidden');
                                $('#modalContent').html('');
                                dataGedung.ajax.reload();
                            });
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
                            text: 'Data gagal disimpan'
                        });
                    }
                });
            });
        });
    </script>
@endpush