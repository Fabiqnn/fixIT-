@extends('layouts_teknisi.template')
@section('title', $page->title)
@section('header', $page->header)

@section('content')
    <div class="font-inter">
        <div class="flex justify-between items-center my-5">
            <h1 class="font-bold text-xl">Daftar Laporan</h1>
            <div class="flex items-center gap-4">
            </div>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="tableLaporan">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="w-[50px] px-4 py-3 text-center">No</th>
                        <th class="px-2 py-3">Prioritas</th> <!-- Tambahan -->
                        <th class="px-2 py-3">Kode Laporan</th>
                        <th class="px-4 py-3 text-left">Fasilitas</th>
                        <th class="px-4 py-3">Ruangan</th> <!-- Tambahan -->
                        <th class="px-4 py-3">Gedung</th>
                        <th class="px-4 py-3">Lantai</th> <!-- Tambahan -->
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white border-l-3">
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded shadow-lg max-w-4xl w-full relative">
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
                    document.getElementById('modalContainer').classList.add('autoAppear');
                    document.querySelectorAll('#modalContent script').forEach((script) => {
                        $.globalEval(script.innerText || script.textContent || script.innerHTML);
                    });
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

        var dataLaporan;
        $(document).ready(function() {
            dataLaporan = $('#tableLaporan').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('teknisi/list_diproses') }}",
                    type: "GET",
                    data: function(d) {
                        d.status_perbaikan = $('#filter_status').val();
                    }
                },
                order: [
                    [1, 'asc']
                ], // ⬅️ Urut default berdasarkan kolom `ranking`
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center w-[50px]",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "ranking", // ✅ Tetap ditampilkan
                        className: "text-center"
                    },
                    {
                        data: "kode_laporan"
                    },
                    {
                        data: "nama_fasilitas"
                    },
                    {
                        data: "nama_ruangan"
                    },
                    {
                        data: "nama_gedung"
                    },
                    {
                        data: "nama_lantai"
                    },
                    {
                        data: "status_perbaikan"
                    },
                    {
                        data: "aksi",
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ]
            });

            $('#filter_status').change(function() {
                dataLaporan.ajax.reload();
            });
        });

        // $(document).ready(function() {
        //     dataLaporan = $('#tableLaporan').DataTable({
        //         serverSide: true,
        //         ajax: {
        //             url: "{{ url('teknisi/list_diproses') }}",
        //             type: "GET",
        //             data: function(d) {
        //                 d.status_perbaikan = $('#filter_status').val();
        //             }
        //         },
        //         columns: [{
        //                 data: "DT_RowIndex",
        //                 className: "text-center w-[50px]",
        //                 orderable: false
        //             },
        //             {
        //                 data: "ranking"
        //             },
        //             {
        //                 data: "kode_laporan"
        //             },
        //             {
        //                 data: "nama_fasilitas"
        //             },
        //             {
        //                 data: "nama_ruangan"
        //             },
        //             {
        //                 data: "nama_gedung"
        //             },
        //             {
        //                 data: "nama_lantai"
        //             },
        //             {
        //                 data: "status_perbaikan"
        //             },
        //             {
        //                 data: "aksi",
        //                 orderable: false,
        //                 searchable: false
        //             }
        //         ]


        //     });

        //     $('#filter_status').change(function() {
        //         dataLaporan.ajax.reload();
        //     });
        // });
    </script>
@endpush
