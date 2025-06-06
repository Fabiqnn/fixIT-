<div class="bg-white rounded-lg shadow-md font-inter">
    <div class="bg-green-700 text-white text-xl font-semibold px-6 py-4 rounded-t">
        Detail Laporan
    </div>

    <div class="p-6 flex flex-col md:flex-row gap-6">
        <div class="flex-shrink-0 w-full md:w-1/3">
            <img src="{{ asset('storage/foto/' . $laporan->foto_kerusakan) }}" alt="Foto Kerusakan"
                class="w-full h-auto rounded-lg object-cover">
        </div>

        <div class="flex-1 space-y-3">
            <h2 class="text-2xl font-bold text-gray-900">{{ $laporan->fasilitas->nama_fasilitas }}</h2>
            <p class="text-gray-700"><strong>Tanggal :</strong>
                {{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->translatedFormat('d F Y') }}</p>
            <p class="text-gray-700"><strong>Gedung :</strong>
                {{ $laporan->fasilitas->ruangan->gedung->gedung_nama ?? '-' }}</p>
            <p class="text-gray-700"><strong>Ruangan :</strong> {{ $laporan->fasilitas->ruangan->keterangan ?? '-' }}
            </p>
            <p class="text-gray-700"><strong>Lantai :</strong>
                {{ $laporan->fasilitas->ruangan->lantai->nama_lantai ?? '-' }}</p>
            <p class="text-gray-700"><strong>Fasilitas :</strong> {{ $laporan->fasilitas->nama_fasilitas ?? '-' }}</p>
            <p class="text-gray-700"><strong>Status :</strong>
                {{ $laporan->status_perbaikan ?? '-' }}</p>

            <div class="pt-4 space-y-2">
                <p class="text-gray-700 font-semibold">Deskripsi Tambahan:</p>
                <div class="text-gray-700 bg-gray-100 p-3 rounded-md max-h-40 overflow-y-auto whitespace-pre-line">
                    {{ $laporan->deskripsi_kerusakan }}
                </div>
            </div>
        </div>
    </div>
</div>
