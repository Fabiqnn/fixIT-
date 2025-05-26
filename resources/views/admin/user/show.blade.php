<div class="space-y-6">
    <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
        Detail User
    </div>
    <div class="p-3 flex flex-col justify-center gap-6">
        <div class="overflow-x-auto">
            <table class="table-auto min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-5 py-3">Nama Lengkap</th>
                        <th class="px-5 py-3">Username</th>
                        <th class="px-5 py-3">Level</th>
                        <th class="px-5 py-3">Jurusan</th>
                        <th class="px-5 py-3">Prodi</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Nomor Telepon</th>
                        <th class="px-5 py-3">NIP</th>
                        <th class="px-5 py-3">NIM</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->nama_lengkap ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->username ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->level->level_nama ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->jurusan->jurusan_nama ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->prodi->prodi_nama ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->email ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->nomor_telp ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->nip ?? '-' }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">{{ $user->nim ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end space-x-4">
            <button type="button" class="button-warning" onclick="closeModal()">Kembali</button>
        </div>
    </div>
</div>
