@extends('layouts.template')
@section('title', $page->title)
@section('header', $page->header)

@section('content')
    <div class="font-inter">
        <div class="flex justify-between mb-20">
            <h3 class="font-bold text-xl">Daftar Fasilitas Kampus</h3>
            <div class="space-x-3">
                <button class="button2">Import</button>
                <a href="" class="button-info inline-flex justify-center items-center">Export</a>
                <button class="button1">Tambah Data Fasilitas</button>
            </div>
        </div>

        <div id="filter" class="grid grid-cols-3 grid-rows-2 gap-2 items-start w-1/3">
            <div class="row-span-2 flex items-center">
                <label for="filter_gedung" class="text-lg font-bold">Filter</label>
            </div>
            <div class="col-span-2 col-start-2">
                <select id="filter_gedung" name="filter_gedung"
                    class="border-1 border-success rounded w-full text-D_grey p-2 outline-none">
                    <option value="">- Semua -</option>
                    {{-- @foreach ($gedung as $g)
                        <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                    @endforeach --}}
                </select>
            </div>
            <div>
                <small class="text-D_grey">Lokasi Fasilitas</small>
            </div>
        </div>

        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700">
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
@endsection

@push('js')
    <script>
        var dataFasilitas;
        $(document).ready(function() {

        });
    </script>
@endpush
