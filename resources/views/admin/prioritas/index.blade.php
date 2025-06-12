@extends('layouts.template')
@section('title', $page->title)
@section('header', $page->header)

@section('content')
    <div>
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar Kriteria</h1>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <button class="button1 cursor-pointer" onclick="modalAction('{{ url('/admin/prioritas/process') }}')">
                        <span class="text-xl mr-2">+</span> Buat Tabel Rekomendasi
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="table_kriteria">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Nama Kriteria</th>
                        <th class="p-4">Tipe Kriteria</th>
                        <th class="p-4">Bobot</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
                </tbody>
            </table>
        </div>
    </div>

    <div>
       <div class="flex flex-col md:flex-row justify-between items-start md:items-center my-5 gap-3 md:gap-0">
        <h1 class="font-bold text-xl">Daftar Alternatif</h1>
        <div class="flex items-center gap-2">
            <label for="gedung_id" class="text-lg font-bold">Filter</label>
            <select id="gedung_id" name="gedung_id"
                class="border border-success rounded text-D_grey p-2 outline-none w-full md:w-50">
                <option value="">- Semua -</option>
                        @foreach ($gedung as $g)
                            <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="button1 cursor-pointer" onclick="modalAction('{{ url('/admin/prioritas/create-alternatif') }}')">
                    <i class="fa-solid fa-plus"></i> Tambah Alternatif
                </button>
            </div>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="table_alternatif">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Nama Fasilitas</th>
                        <th class="p-4">Gedung</th>
                        <th class="p-4">Lantai</th>
                        <th class="p-4">Ruangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar Tabel Matriks Keputusan</h1>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="table_penilaian">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="p-4">Alternatif</th>
                        <th class="p-4">K1</th>
                        <th class="p-4">K2</th>
                        <th class="p-4">K3</th>
                        <th class="p-4">K4</th>
                        <th class="p-4">K5</th>
                        <th class="p-4">Aksi</th>
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

                    if (typeof initTambahValidasi === "function") {
                        initTambahValidasi();
                    }

                    if (typeof initDeleteValidasi === "function") {
                        initDeleteValidasi();
                    }

                    if (typeof initEditValidasi === "function") {
                        initEditValidasi();
                    }

                    if (typeof initTugaskanValidasi === "function") {
                        initTugaskanValidasi();
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
        
        var dataKriteria;
        var dataAlternatif;
        var dataPenilaian;
        $(document).ready(function() {
            dataKriteria = $('#table_kriteria').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/prioritas/list-kriteria') }}",
                    "type": "GET",
                    "dataType": "json",
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nama_kriteria",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    data: "tipe_kriteria",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "bobot",
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

            dataAlternatif = $('#table_alternatif').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/prioritas/list-alternatif') }}",
                    "type": "GET",
                    "dataType": "json",
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
                    data: "gedung_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "nama_lantai",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "kode_ruangan",
                    type: 'string',
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

            dataPenilaian = $('#table_penilaian').DataTable({
                serverSide: true,
                ajax: {
                   "url": "{{ url('admin/prioritas/list-penilaian') }}",
                   "type": "GET",
                   "dataType": "json",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: '#' },
                    { data: 'alternatif', name: 'alternatif', title: 'Alternatif' },
                    { data: 'K1', name: 'K1', title: 'K1' },
                    { data: 'K2', name: 'K2', title: 'K2' },
                    { data: 'K3', name: 'K3', title: 'K3' },
                    { data: 'K4', name: 'K4', title: 'K4' },
                    { data: 'K5', name: 'K5', title: 'K5' },
                    { data: "aksi", name: 'Aksi', title: 'Aksi', className: "", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush