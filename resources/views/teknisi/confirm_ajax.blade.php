<div class="space-y-6">
    <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
        Konfirmasi Tugas Selesai
    </div>
    <div class="p-3 flex flex-col justify-center gap-6">
        <div class="overflow-x-auto">
            <p class="text-gray-700 leading-relaxed">
                Konfirmasi apakah tugas
                <span class="font-semibold text-gray-900">{{ $laporan->kode_laporan }}</span>
                <span class="font-semibold text-green-700">selesai</span>?
            </p>
        </div>


        <div class="flex justify-end gap-3 pt-6">
            <button onclick="closeModal()"
                class="cursor-pointer px-5 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 transition-all duration-150">
                Batal
            </button>

            <button onclick="submitTuntas({{ $laporan->laporan_id }})"
                class="cursor-pointer px-5 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition-all duration-150">
                Ya, Selesai
            </button>
        </div>
    </div>
</div>

<script>
    function submitTuntas(id) {
        fetch(`/teknisi/laporan/${id}/selesai`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Laporan telah ditandai sebagai tuntas.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        closeModal();
                        $('#tableLaporan').DataTable().ajax.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        text: data.message || 'Gagal memperbarui status.',
                        icon: 'error',
                        confirmButtonText: 'Tutup'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    title: 'Kesalahan!',
                    text: 'Terjadi kesalahan saat mengirim permintaan.',
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                });
            });
    }
</script>
