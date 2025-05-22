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
            <table class="min-w-full text-sm text-left text-gray-700" id="tableUser">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="w-[50px] px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3 text-left">Nama Lengkap</th>
                        <th class="w-[220px] px-4 py-3 text-right">Nama Level</th>
                        <th class="w-[220px] px-4 py-3 text-right">Email</th>
                        <th class="w-[220px] px-4 py-3 text-right">No Telepon</th>
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

        var dataUser;
        $(document).ready(function() {
            dataUser = $('#tableUser').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('admin/user/list') }}",
                    type: "GET",
                    dataType: "json"
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_lengkap",
                        className: "text-left",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "level_nama",
                        className: "text-right",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "email",
                        className: "text-right",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nomor_telp",
                        className: "text-right",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-right",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
