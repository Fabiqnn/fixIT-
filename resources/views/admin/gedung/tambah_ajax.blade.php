@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form action="{{ url('/admin/building/store') }}" method="POST" class="space-y-4 font-inter">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tambah Gedung
        </div>
        <div class="p-6 space-y-3">
            <div>
                <label class="block mb-1 font-semibold">Nama Gedung</label>
                <input type="text" name="gedung_nama" class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="Contoh: T.Sipil, T.Mesin, AJ" required>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">Tambah</button>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        $(document).ready(function() {
            $('#form-gedung').on('submit', function(e) {
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
