<div class="space-y-6">
    <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
        Detail Fasilitas
    </div>
    <div class="p-3 flex flex-col justify-center gap-6">
        <div class="mx-auto space-y-3">
            <table class="table-auto min-w-max  divide-y divide-gray-200 text-sm text-left text-gray-700" id="table_fasilitas">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr class="table-row">
                        <th class="px-5 py-3">Nama Fasilitas</th>
                        <th class="px-5 py-3">Kode Fasilitas</th>
                        <th class="px-5 py-3">Gedung</th>
                        <th class="px-5 py-3">Lantai</th>
                        <th class="px-5 py-3">Ruangan</th>
                        <th class="px-5 py-3">Tanggal Pengadaan</th>
                        <th class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-5 py-4 whitespace-nowrap">{{$fasilitas->nama_fasilitas ?? '-'}} </td>
                        <td class="px-5 py-4 whitespace-nowrap">{{$fasilitas->kode_fasilitas ?? '-'}} </td>
                        <td class="px-5 py-4 whitespace-nowrap">{{$fasilitas->ruangan->gedung->gedung_nama ?? '-' }} </td>
                        <td class="px-5 py-4 whitespace-nowrap">{{$fasilitas->ruangan->lantai->nama_lantai ?? '-'}} </td>
                        <td class="px-5 py-4 whitespace-nowrap">{{$fasilitas->ruangan->kode_ruangan ?? '-'}} </td>
                        <td class="px-5 py-4 whitespace-nowrap">{{$fasilitas->tanggal_pengadaan ?? '-'}} </td>
                        <td class="px-5 py-4 whitespace-nowrap">{{$fasilitas->status ?? '-'}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end space-x-4">
            <button type="button" class="button-warning" onclick="closeModal()">Kembali</button>
        </div>
    </div>
</div>