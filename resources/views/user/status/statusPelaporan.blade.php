@extends('layouts_user.template')

@section('content')
<div class="bg-green-700 text-white text-lg font-bold p-4 rounded-br-2xl">
    Status Pelaporan
</div>
<div class="h-svh">
    <div class="container mx-auto p-6 my-10 shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-xl rounded-xl">
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="py-3 px-5 text-left">Kode Laporan</th>
                        <th class="py-3 px-5 text-left">Fasilitas</th>
                        <th class="py-3 px-5 text-left">Tanggal</th>
                        <th class="py-3 px-5 text-left">Gedung</th>
                        <th class="py-3 px-5 text-left">Deskripsi Tambahan</th>
                        <th class="py-3 px-5 text-left">Detail</th>
                        <th class="py-3 px-5 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @foreach ($laporan as $item)
                    <tr class="border-t border-gray-200">
                        <td class="py-3 px-5 font-bold">{{ $item->kode_laporan }}</td>
                        <td class="py-3 px-5">{{ $item->fasilitas->nama_fasilitas ?? 'N/A' }}</td>
                        <td class="py-3 px-5 text-gray-400">{{ \Carbon\Carbon::parse($item->tanggal_laporan)->translatedFormat('d F Y') }}</td>
                        <td class="py-3 px-5">{{ $item->fasilitas->ruangan->lantai->gedung->gedung_nama }}</td>
                        <td class="py-3 px-5">{{ $item->deskripsi_kerusakan }}</td>
                        <td class="py-3 px-5">
                            <button 
                                class="bg-green-500 text-white px-4 py-1 rounded-full hover:bg-green-600 open-detail" 
                                data-id="{{ $item->laporan_id }}">
                                Detail
                            </button>
                        </td>
                        <td class="py-3 px-5">
                            <span class="bg-green-500 text-white px-4 py-1 rounded-full">
                                {{ ucfirst($item->status_perbaikan) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Static Pagination -->
        <div class="mt-4">
            {{ $laporan->links() }}
        </div>
</div>

    {{-- <p class="text-sm text-gray-500 mt-2">
    Showing {{ $laporan->firstItem() }}–{{ $laporan->lastItem() }} from {{ $laporan->total() }} data
    </p> --}}
    <!-- Modal -->
<div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden overflow-auto">
    <div class="bg-white rounded shadow-lg max-w-4xl w-full relative my-auto" id="modal-box">
        <button onclick="closeModal()"
            class="absolute top-4.5 right-6 text-gray-800 hover:text-red-600 text-2xl font-bold cursor-pointer">
            &times;
        </button>
        <div id="modalContent" class="p-6"></div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.open-detail');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const url = `{{ url('status/') }}/${id}/show`

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('modalContainer').classList.remove('hidden');
                        document.getElementById('modalContainer').classList.add('flex');
                    })
                    .catch(error => {
                        alert('Gagal mengambil data: ' + error.message);
                    });
            });
        });
    });

    function closeModal() {
        document.getElementById('modalContainer').classList.add('hidden');
        document.getElementById('modalContainer').classList.remove('flex');
        document.getElementById('modalContent').innerHTML = '';
    }
</script>


@endsection
