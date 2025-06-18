@extends('layouts.template')
@section('title', $page->title)
@section('header', $page->header)

@section('content')
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center my-5 gap-3 md:gap-0">
        <h1 class="font-bold text-xl">Daftar Fasilitas Kampus</h1>
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
                        <th class="p-4">Lantai</th>
                        <th class="p-4">Ruangan</th>
                        <th class="p-4">Tanggal Pengadaan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded shadow-lg max-w-screen-xl w-full relative" id="modal-box">
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
                    data: "kode_ruangan",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nama_lantai",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "tanggal_pengadaan",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "status",
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

            $('#gedung_id').on('change', function() {
            dataFasilitas.ajax.reload();
            });
        });
    </script>
@endpush
