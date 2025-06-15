<div class="space-y-6">
    <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
        Hasil Rekomendasi
    </div>
    <div class="p-3 gap-6">
        <div class="mx-auto space-y-3 mb-3">
            <div class="space-y-5">
                <span class="font-semibold">Matriks Normalisasi</span>
                <div class="p-3 w-full border border-success rounded">
                    <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="text-D_grey font-semibold uppercase text-xs border-b-1">
                        <tr>
                            <th>Fasilitas</th>
                            @foreach(array_keys($hasil['R'][array_key_first($hasil['R'])]) as $kriteria)
                                <th>{{ $kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($hasil['R'] as $alt_id => $nilai)
                            <tr class="py-1">
                                <td class="">{{ $namaFasilitas[$alt_id] ?? $alt_id }}</td>
                                @foreach($nilai as $v)
                                    <td class="">{{ $v }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="space-y-5">
                <span class="font-semibold">Matriks Tertimbang (V)</span>
                <div class="p-3 w-full border border-success rounded">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="text-D_grey font-semibold uppercase text-xs border-b-1">
                            <tr>
                                <th>Fasilitas</th>
                                @foreach(array_keys($hasil['V'][array_key_first($hasil['V'])]) as $kriteria)
                                    <th>{{ $kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($hasil['V'] as $alt_id => $nilai)
                                <tr class="py-1">
                                    <td class="">{{ $namaFasilitas[$alt_id] ?? $alt_id }}</td>
                                    @foreach($nilai as $v)
                                        <td class="">{{ $v }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="space-y-5">
                <span class="font-semibold">Matriks Area Perkiraan Perbatasan (G)</span>
                <div class="p-3 w-full border border-success rounded">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="text-D_grey font-semibold uppercase text-xs border-b-1">
                            <tr>
                                @foreach($hasil['G'] as $kriteria => $nilai)
                                    <th>{{ $kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr class="py-1">
                                @foreach($hasil['G'] as $nilai)
                                    <td class="">{{ $nilai }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="space-y-5">
                <span class="font-semibold">Perangkingan</span>
                <div class="p-3 w-full border border-success rounded">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="text-D_grey font-semibold uppercase text-xs border-b-1">
                            <th>Rangking</th>
                            <th>Alternatif</th>
                            <th>Nilai Q</th>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($hasil['rangking'] as $item)
                                <tr class="py-1">
                                    <td>{{$item['ranking']}} </td>
                                    <td>{{$namaFasilitas[$item['alternatif_id']]}} </td>
                                    <td>{{$item['nilai_q']}} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex justify-end space-x-4">
            <button type="button" class="button-warning" onclick="closeModal()">Kembali</button>
            <button type="button" class="button-info" onclick="modalAction('{{url('/admin/prioritas/tugaskan')}}')">Tugaskan Teknisi</button>
        </div>
    </div>
</div>