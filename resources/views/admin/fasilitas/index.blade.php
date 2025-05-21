@extends('layouts.template')
@section('title', $page->title)
@section('header', $page->header)

@section('content')
    {{-- <div class="font-inter">
        <div class="flex justify-between mb-20">
            <h3 class="font-bold text-xl">Daftar Fasilitas Kampus</h3>
            <div class="space-x-3">
                <button class="button2">Import</button>
                <a href="" class="button-info inline-flex justify-center items-center">Export</a>
                <button class="button1" onclick="modalAction('{{ url('admin/fasilitas/create') }}')">Tambah Data
                    Fasilitas</button>
            </div>
        </div>

        <div id="filter" class="grid grid-cols-3 grid-rows-2 gap-2 items-start w-1/3">
            <div class="row-span-2 flex items-center">
                <label for="gedung_id" class="text-lg font-bold">Filter</label>
            </div>
            <div class="col-span-2 col-start-2">
                <select id="gedung_id" name="gedung_id"
                    class="border-1 border-success rounded w-full text-D_grey p-2 outline-none">
                    <option value="">- Semua -</option>
                    @foreach ($gedung as $g)
                        <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <small class="text-D_grey">Lokasi Fasilitas</small>
            </div>
        </div> --}}
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar Fasilitas Kampus</h1>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label for="gedung_id" class="text-lg font-bold">Filter</label>
                    <select id="gedung_id" name="gedung_id"
                        class="border border-success rounded text-D_grey p-2 outline-none w-50">
                        <option value="">- Semua -</option>
                        {{-- @foreach ($gedung as $g)
                            <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                        @endforeach --}}
                    </select>
                </div>
                <button class="button2 cursor-pointer w-"> Import</button>
                <button class="button1 cursor-pointer" onclick="modalAction('{{ url('/admin/fasilitas/create') }}')">
                    <i class="fa-solid fa-plus"></i> Tambah
                </button>
            </div>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="table_fasilitas">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Nama Fasilitas</th>
                        <th class="p-4">Kode Fasilitas</th>
                        <th class="p-4">Gedung</th>
                        <th class="p-4">Tanggal Pengadaan</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-l-3">
                    <tr>
                        <td class="p-4">1</td>
                        <td class="p-4">AC</td>
                        <td class="p-4">AC001</td>
                        <td class="p-4">TI</td>
                        <td class="p-4">10/09/2015</td>
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

        var dataFasilitas;
        $(document).ready(function() {
            dataFasilitas = $('#table_fasilitas').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/fasilitas/list') }}",
                    "type": "GET",
                    "dataType": "json",
                    "data": function(d) {
                        d.gedung_id = $('#gedung_id').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nama_fasilitas",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    data: "kode_fasilitas",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "gedung_nama",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "tanggal_pengadaan",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
        });
    </script>
@endpush
