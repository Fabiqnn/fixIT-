<div class="space-y-6">
    <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
        Detail Gedung
    </div>
    <div class="p-3 flex flex-col justify-center gap-6">
        <div class="mx-auto space-y-3">
            <table class="table-auto min-w-max divide-y divide-gray-200 text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-5 py-3">ID Gedung</th>
                        <th class="px-5 py-3">Nama Gedung</th>
                        <th class="px-5 py-3">Dibuat</th>
                        <th class="px-5 py-3">Terakhir Diperbarui</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $gedung->gedung_id ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $gedung->gedung_nama ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            {{ $gedung->created_at ? $gedung->created_at->format('d-m-Y H:i') : '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            {{ $gedung->updated_at ? $gedung->updated_at->format('d-m-Y H:i') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end space-x-4">
            <button type="button" class="button-warning" onclick="closeModal()">Kembali</button>
        </div>
    </div>
</div>
