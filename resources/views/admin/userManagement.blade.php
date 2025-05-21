@extends('layouts.template')

@section('title', 'Admin')

@section('header', 'User Manajemen')
@section('content')
    <div class="font-inter">
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar User</h1>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label for="filter_user" class="text-lg font-bold">Filter</label>
                    <select id="filter_user" name="filter_user"
                        class="border border-success rounded text-D_grey p-2 outline-none w-50">
                        <option value="">- Semua -</option>
                    </select>
                </div>
                <button class="button1 cursor-pointer" onclick="modalAction('{{ url('/admin/userCreateAjax') }}')">
                    <span class="text-xl mr-2">+</span> Tambah
                </button>
            </div>
        </div>
        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Nama</th>
                        <th class="p-4">NIM</th>
                        <th class="p-4">Tanggal Lahir</th>
                        <th class="p-4">Nama Level</th>
                        <th class="p-4">Kelas</th>
                        <th class="p-4">Kontak</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-l-3">
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">1</td>
                        <td class="p-4 font-semibold">Robi Alvian</td>
                        <td class="p-4">123456789</td>
                        <td class="p-4 text-gray-400">13 Maret 2004</td>
                        <td class="p-4">Mahasiswa</td>
                        <td class="p-4">TI 2F</td>
                        <td class="p-4 font-bold">123456789</td>
                        <td class="p-4 flex justify-evenly">
                            <button class="button-info">Detail</button>
                            <button class="button1">Edit</button>
                            <button class="button-error">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded shadow-lg max-w-2xl w-full relative">
            <button onclick="closeModal()"
                class="absolute top-4.5 right-6 text-white hover:text-gray-700 text-2xl font-bold cursor-pointer">
                &times;
            </button>
            <div id="modalContent"></div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('modalContent').innerHTML = html;
                    document.getElementById('modalContainer').classList.remove('hidden');
                    document.getElementById('modalContainer').classList.add('flex');
                })
                .catch(error => {
                    console.error('Error fetching modal:', error);
                });
        }

        function closeModal() {
            document.getElementById('modalContainer').classList.remove('flex');
            document.getElementById('modalContainer').classList.add('hidden');
            document.getElementById('modalContent').innerHTML = '';
        }
    </script>
@endpush
