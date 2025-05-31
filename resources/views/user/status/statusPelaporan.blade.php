@extends('layouts_user.template')

@section('content')
<div class="bg-green-700 text-white text-lg font-bold p-4 rounded-br-2xl">
    Status Pelaporan
</div>
<div class="container mx-auto p-6 my-10 shadow-xl">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-xl rounded-xl">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="py-3 px-5 text-left">Kode Laporan</th>
                    <th class="py-3 px-5 text-left">Fasilitas</th>
                    <th class="py-3 px-5 text-left">Tanggal</th>
                    <th class="py-3 px-5 text-left">Prioritas</th>
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
                    <td class="py-3 px-5">{{ $item->prioritas ?? '-' }}</td> 
                    <td class="py-3 px-5">{{ $item->fasilitas->ruangan->lantai->gedung->gedung_nama }}</td>
                    <td class="py-3 px-5">{{ $item->deskripsi_kerusakan }}</td>
                    <td class="py-3 px-5">
                        <button class="bg-green-500 text-white px-4 py-1 rounded-full hover:bg-green-600">Detail</button>
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

    <p class="text-sm text-gray-500 mt-2">
    Showing {{ $laporan->firstItem() }}–{{ $laporan->lastItem() }} from {{ $laporan->total() }} data
    </p>

@endsection
