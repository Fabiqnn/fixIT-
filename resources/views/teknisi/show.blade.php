<div class="bg-white rounded-lg shadow-md font-inter">
    <div class="bg-green-700 text-white text-xl font-semibold px-6 py-4 rounded-t">
        Detail Laporan
    </div>

    <div class="p-6 flex flex-col md:flex-row gap-6">
        <div class="flex-shrink-0 w-full md:w-1/3">
            <img src="{{ asset('/' . $rekomendasi->alternatif->laporan->foto_kerusakan) }}"
                alt="Foto Kerusakan" class="w-full h-auto rounded-lg object-cover">
        </div>

        <div class="flex-1 space-y-3">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ $rekomendasi->alternatif->laporan->fasilitas->nama_fasilitas }}</h2>
            <p class="text-gray-700"><strong>Tanggal :</strong>
                {{ \Carbon\Carbon::parse($rekomendasi->alternatif->laporan->tanggal_laporan)->translatedFormat('d F Y') }}
            </p>
            <p class="text-gray-700"><strong>Gedung :</strong>
                {{ $rekomendasi->alternatif->laporan->fasilitas->ruangan->gedung->gedung_nama ?? '-' }}</p>
            <p class="text-gray-700"><strong>Ruangan :</strong>
                {{ $rekomendasi->alternatif->laporan->fasilitas->ruangan->keterangan ?? '-' }}
            </p>
            <p class="text-gray-700"><strong>Lantai :</strong>
                {{ $rekomendasi->alternatif->laporan->fasilitas->ruangan->lantai->nama_lantai ?? '-' }}</p>
            <p class="text-gray-700"><strong>Fasilitas :</strong>
                {{ $rekomendasi->alternatif->laporan->fasilitas->nama_fasilitas ?? '-' }}</p>
            <p class="text-gray-700"><strong>Status :</strong>
                {{ $rekomendasi->alternatif->laporan->status_perbaikan ?? '-' }}</p>

            <div class="pt-4 space-y-2">
                <p class="text-gray-700 font-semibold">Deskripsi Tambahan:</p>
                <div class="text-gray-700 bg-gray-100 p-3 rounded-md max-h-40 overflow-y-auto whitespace-pre-line">
                    {{ $rekomendasi->alternatif->laporan->deskripsi_kerusakan }}
                </div>
            </div>

                    <div class="pt-4 space-y-2">
                        <p class="text-gray-700 font-semibold">Rating dan Umpan Balik:</p>

                        @forelse ($rekomendasi->umpanBalik as $umpan)
                            <div class="bg-gray-100 p-3 rounded-md text-gray-800 space-y-1">
                                {{-- <p><strong>Dari:</strong> {{ $umpan->user->nama_lengkap ?? $umpan->no_induk }}</p> --}}
                                <p class="flex items-center gap-1">
                                    <strong>Rating:</strong>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $umpan->skala_kepuasan)
                                            <span class="text-yellow-400">&#9733;</span>
                                        @else
                                            <span class="text-gray-300">&#9733;</span>
                                        @endif
                                    @endfor
                                </p>
                                <p><strong>Komentar:</strong></p>
                                <div class="bg-white p-2 rounded border border-gray-300 max-h-40 overflow-y-auto whitespace-pre-line">
                                    {{ $umpan->komentar }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada umpan balik.</p>
                        @endforelse
                    </div>
        </div>
    </div>
</div>
