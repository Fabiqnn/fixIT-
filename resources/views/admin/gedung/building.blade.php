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
                <button class="button1 cursor-pointer" onclick="modalAction('{{ url('/admin/building/create') }}')">
                    <span class="text-xl mr-2">+</span> Tambah
                </button>
            </div>
        </div>
        <div class="overflow-x-auto border-y-1 border-gray1">
            <table id="tableGedung" class="w-full table-fixed text-sm text-gray-800 rounded-md ">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="w-[50px] px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3 text-left">Nama Gedung</th>
                        <th class="w-[220px] px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
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


        var dataGedung;
        $(document).ready(function() {
            dataGedung = $('#tableGedung').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('admin/building/list') }}",
                    type: "GET",
                    dataType: "json"
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "gedung_nama",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center", // kamu bisa ubah ke text-center jika mau
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
