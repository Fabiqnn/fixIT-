@extends('layouts.template')
@section('title', $page->title)
@section('header', $page->header)

@section('content')
    <div>
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar Laporan Pending</h1>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label for="gedung_id_pending" class="text-lg font-bold">Filter</label>
                    <select id="gedung_id_pending" name="gedung_id"
                        class="border border-success rounded text-D_grey p-2 outline-none w-50">
                        <option value="">- Semua -</option>
                        @foreach ($gedung as $g)
                            <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="table_laporan_pending">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Kode Laporan</th>
                        <th class="p-4">Nama Fasilitas</th>
                        <th class="p-4">Ruangan</th>
                        <th class="p-4">Lantai</th>
                        <th class="p-4">Gedung</th>
                        <th class="p-4">Tanggal Laporan</th>
                        <th class="p-4">Status Acc</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar Laporan Acc</h1>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label for="gedung_id_acc" class="text-lg font-bold">Filter</label>
                    <select id="gedung_id_acc" name="gedung_id"
                        class="border border-success rounded text-D_grey p-2 outline-none w-50">
                        <option value="">- Semua -</option>
                        @foreach ($gedung as $g)
                            <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="table_laporan_acc">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Kode Laporan</th>
                        <th class="p-4">Nama Fasilitas</th>
                        <th class="p-4">Ruangan</th>
                        <th class="p-4">Lantai</th>
                        <th class="p-4">Gedung</th>
                        <th class="p-4">Tanggal Laporan</th>
                        <th class="p-4">Status Acc</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar Laporan Dec</h1>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label for="gedung_id_dec" class="text-lg font-bold">Filter</label>
                    <select id="gedung_id_dec" name="gedung_id"
                        class="border border-success rounded text-D_grey p-2 outline-none w-50">
                        <option value="">- Semua -</option>
                        @foreach ($gedung as $g)
                            <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="table_laporan_dec">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Kode Laporan</th>
                        <th class="p-4">Nama Fasilitas</th>
                        <th class="p-4">Ruangan</th>
                        <th class="p-4">Lantai</th>
                        <th class="p-4">Gedung</th>
                        <th class="p-4">Tanggal Laporan</th>
                        <th class="p-4">Status Acc</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden overflow-auto">
        <div class="bg-white rounded shadow-lg max-w-4xl w-full relative my-auto" id="modal-box">
            <button onclick="closeModal()"
                class="absolute top-4.5 right-6 text-white hover:text-gray-700 text-2xl font-bold cursor-pointer">
                &times;
            </button>
            <div id="modalContent" class="w-full"></div>
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
                    document.getElementById('modalContainer').classList.add('autoAppear');
                    document.getElementById('modal-box').classList.add('autoShow3');

                    $('#modalContent script').each(function() {
                        $.globalEval(this.text || this.textContent || this.innerHTML || '');
                    });

                    if (typeof initDecValidasi === "function") {
                        initDecValidasi();
                    }

                    if (typeof initAccValidasi === "function") {
                        initAccValidasi();
                    }

                    if (typeof initEditValidasi === "function") {
                        initEditValidasi();
                    }
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
        
        var dataPelaporanPending;
        var dataPelaporanDec;
        var dataPelaporanAcc;

        // Pending
        $(document).ready(function() {
            dataPelaporanPending = $('#table_laporan_pending').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/pelaporan/list-pending') }}",
                    "type": "GET",
                    "dataType": "json",
                    "data": function(d) {
                        d.gedung_id_pending = $('#gedung_id_pending').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "kode_laporan",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "nama_fasilitas",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_ruangan",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_lantai",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_gedung",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    // mengambil data level hasil dari ORM berelasi
                    data: "tanggal_laporan",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "status_acc",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

            $('#gedung_id_pending').on('change', function() {
            dataPelaporanPending.ajax.reload();
            });

            // acc
            dataPelaporanAcc = $('#table_laporan_acc').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/pelaporan/list-acc') }}",
                    "type": "GET",
                    "dataType": "json",
                    "data": function(d) {
                        d.gedung_id_acc = $('#gedung_id_acc').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "kode_laporan",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "nama_fasilitas",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_ruangan",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_lantai",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_gedung",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    // mengambil data level hasil dari ORM berelasi
                    data: "tanggal_laporan",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "status_acc",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

            $('#gedung_id_acc').on('change', function() {
            dataPelaporanAcc.ajax.reload();
            });

            // dec
            dataPelaporanDec = $('#table_laporan_dec').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/pelaporan/list-dec') }}",
                    "type": "GET",
                    "dataType": "json",
                    "data": function(d) {
                        d.gedung_id_dec = $('#gedung_id_dec').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "kode_laporan",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "nama_fasilitas",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_ruangan",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_lantai",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "nama_gedung",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    // mengambil data level hasil dari ORM berelasi
                    data: "tanggal_laporan",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "status_acc",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

            $('#gedung_id_dec').on('change', function() {
            dataPelaporanDec.ajax.reload();
            });
        });
    </script>
@endpush