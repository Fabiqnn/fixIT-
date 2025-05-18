@extends('layouts.template')

@section('title', 'Admin')

@section('header', 'Building Manajemen')

@section('content')
    <div class="font-inter">
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar Gedung</h1>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label for="filter_gedung" class="text-lg font-bold">Filter</label>
                    <select id="filter_gedung" name="filter_gedung"
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
                        <th class="p-4">Kode Gedung</th>
                        <th class="p-4">Nama Ruangan</th>
                        <th class="p-4">Gedung</th>
                        <th class="p-4">Lantai</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-l-3">
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">1</td>
                        <td class="p-4">JTI0003</td>
                        <td class="p-4">Laboratorium</td>
                        <td class="p-4 font-semibold">JTI</td>
                        <td class="p-4 text-gray-400">IV</td>
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

    {{-- <div id="modalContainer"
        class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative">
            <button onclick="closeModal()"
                class="absolute top-3 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold cursor-pointer">
                &times;
            </button>


            <div id="modalContent"></div>
        </div>
    </div> --}}
@endsection

@push('js')
    {{-- <script>
        function modalAction(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('modalContent').innerHTML = html;
                    document.getElementById('modalContainer').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching modal:', error);
                });
        }

        function closeModal() {
            document.getElementById('modalContainer').classList.add('hidden');
            document.getElementById('modalContent').innerHTML = '';
        }
    </script> --}}
@endpush
