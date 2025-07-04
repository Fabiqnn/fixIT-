@extends('layouts.template')

@section('title', $page->title)

@section('header', $page->header)
@section('content')
    <div class="font-inter">
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Tabel Periode</h1>
            <div class="flex items-center gap-4">
                <button class="button1 cursor-pointer" onclick="modalAction('{{ url('/admin/periode/create') }}')">
                    <span class="text-xl mr-2">+</span> Tambah
                </button>
            </div>
        </div>
        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="table-periode">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="w-[50px] px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3 text-left">Nama Periode</th>
                        <th class="w-[220px] px-4 py-3">Tanggal Mulai</th>
                        <th class="w-[220px] px-4 py-3">Tanggal Selesai</th>
                        <th class="w-[220px] px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
                </tbody>
            </table>
        </div>
    </div>
    <div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded shadow-lg max-w-4xl w-full relative" id="modal-box">
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

                    document.querySelectorAll('#modalContent script').forEach((script) => {
                        $.globalEval(script.innerText || script.textContent || script.innerHTML);
                    });

                    if (typeof initTambahValidasi === "function") {
                        initTambahValidasi();
                    }
                    if (typeof initEditValidasi === "function") {
                        initEditValidasi();
                    }
                    if (typeof initDeleteValidasi === "function") {
                        initDeleteValidasi();
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

        var dataPeriode;
        $(document).ready(function() {
            dataPeriode = $('#table-periode').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('admin/periode/list') }}",
                    type: "GET",
                    dataType: "json"
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "w-[50px] px-4 py-3 text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_periode",
                        className: "px-4 py-3 text-left",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal_mulai",
                        className: "text-left",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "tanggal_selesai",
                        className: "text-left",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
