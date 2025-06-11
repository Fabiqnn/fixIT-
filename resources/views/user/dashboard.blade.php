@extends('layouts_user.template')

@section('title', 'Dashboard Mahasiswa | fixIT!')

@section('content')
    <!-- Header dengan gambar -->
    <div class="w-full h-40 px-3 mb-5">
        <div class="w-full h-full relative">
            <img src="{{ asset('assets/bg1.jpg') }}" alt="" class="h-full w-full object-cover rounded-b-lg">
            <div class="bg-black/50 h-full w-full absolute top-0 left-0 rounded-b-lg"></div>
            <div class="absolute inset-0 flex items-center pl-5">
                <h1 class="text-white font-semibold text-2xl tracking-wide">Dashboard</h1>
            </div>
        </div>
    </div>

    <!-- Sidebar & Detail Panel -->
    <div class="h-[calc(100vh-14rem)] mx-3 border border-gray-300 p-0 rounded-lg shadow-md flex overflow-hidden mb-5">
        <!-- Sidebar -->
        <div class="w-1/3 max-w-lg bg-white flex flex-col h-full">
            <div class="flex justify-between border-b">
                <div class="p-4 font-semibold text-green-700 text-lg">Menu</div>
                <div class="my-auto mr-3">
                    <select id="gedung_id" name="gedung_id"
                        class="border border-green-700 rounded text-gray-700 p-2 outline-none">
                        <option value="">- Filter -</option>
                        {{-- @foreach ($gedung as $g)
                            <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
            <ul id="menuList" class="flex-1 overflow-y-auto divide-y divide-gray-200">
                @foreach ($rekomendasi as $item)
                    @if($item->alternatif)
                        <li onclick="loadItem({{ $item->rekomendasi_id }})" class="cursor-pointer hover:bg-green-50 px-5 py-4 transition-colors space-y-3">
                            <div class="font-medium">{{$item->alternatif->laporan->fasilitas->nama_fasilitas}} </div>
                            @if ($item->alternatif->laporan->status_perbaikan == 'tuntas')
                                <div class="flex justify-between">
                                    <div class="px-3 py-1 rounded-2xl bg-success text-white text-sm w-1/4 text-center">
                                        Tuntas
                                    </div>
                                    <ul class="flex font-light text-sm space-x-3">
                                        <li>{{$item->alternatif->laporan->fasilitas->ruangan->gedung->gedung_nama}}</li>
                                        <li>{{$item->alternatif->laporan->fasilitas->ruangan->lantai->nama_lantai}}</li>
                                        <li>{{$item->alternatif->laporan->fasilitas->ruangan->kode_ruangan}}</li>
                                    </ul>
                                </div>
                            @else
                                <div class="flex justify-between">
                                    <div class="px-3 py-1 rounded-2xl bg-info text-white text-sm w-1/4 text-center">
                                        {{$item->alternatif->laporan->status_perbaikan}}
                                    </div>
                                    <ul class="flex font-light text-sm space-x-3">
                                        <li>{{$item->alternatif->laporan->fasilitas->ruangan->gedung->gedung_nama}}</li>
                                        <li>{{$item->alternatif->laporan->fasilitas->ruangan->lantai->nama_lantai}}</li>
                                        <li>{{$item->alternatif->laporan->fasilitas->ruangan->kode_ruangan}}</li>
                                    </ul>
                                </div>
                            @endif
                        </li>
                    @else
                        <div class="flex flex-col justify-center items-center text-gray-400 h-full">
                            <i class="fa-regular fa-face-sad-tear text-4xl mb-4"></i>
                            <p class="text-sm">Belum ada fasilitas yang dikerjakan oleh teknisi</p>
                        </div>
                    @endif
                @endforeach
            </ul>
        </div>

        <!-- Detail Panel -->
        <div id="detail-panel" class="flex-1 bg-gray-50 p-6 overflow-y-auto h-full">
            <div id="detail-placeholder" class="flex flex-col justify-center items-center text-gray-400 h-full">
                <i class="fa-regular fa-hand-pointer text-4xl mb-4"></i>
                <p class="text-lg">Pilih salah satu item dari menu di kiri.</p>
            </div>
            <div id="detail-content" class="pt-4"></div>
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
        function loadItem($id) {
            const url = `{{ url('/detail-rekomendasi') }}/` + $id;

            fetch(url)
            .then(res => res.json())
            .then(data => {
                document.getElementById('detail-placeholder').style.display = 'none';

                let html = ""

                html += `
                    <h2 class="text-4xl font-semibold text-green-700 mb-4">
                        Detail Data Perbaikan Fasilitas ${data.fasilitas}
                    </h2>
                    <div class="mb-5 pb-4">
                        <div class="flex w-full space-x-5 justify-between">
                            <div class="flex space-x-5 items-end">
                                <div class="px-3 py-1 rounded-2xl bg-success text-white text-sm text-center">
                                    <i class="fa-solid fa-check"></i> ${data.status}
                                </div>
                                <p class="font-light">Info Fasilitas</p>
                            </div>`;
                if (data.status === 'tuntas') {
                    html += `<button class="button1 cursor-pointer text-right outline-none" onclick="modalAction('{{ url('/penilaian/${data.rekomendasi_id}') }}')">
                                <span class="text-md mr-2"><i class="fa-regular fa-star"></i></span> Beri Penilaian
                            </button>`;
                } else {
                    html += `<button class="button1 cursor-pointer text-right outline-none" disabled>
                                <span class="text-md mr-2"><i class="fa-regular fa-star"></i></span> Beri Penilaian
                            </button>`;
                }
                html += `
                        </div>
                        <div class="flex w-full space-x-5 mt-5">
                            <div class="w-1/4 shadow-sm rounded px-3 py-3 bg-gray-100">
                                <h1 class="font-semibold">${data.nama_periode}</h1>
                                <p class="font-light">Periode</p>
                            </div>
                            <div class="w-1/4 shadow-sm rounded px-3 py-3 bg-gray-100">
                                <h1 class="font-semibold">${data.gedung}</h1>
                                <p class="font-light">Gedung</p>
                            </div>
                            <div class="w-1/4 shadow-sm rounded px-3 py-3 bg-gray-100">
                                <h1 class="font-semibold">${data.lantai}</h1>
                                <p class="font-light">Lantai</p>
                            </div>
                            <div class="w-1/4 shadow-sm rounded px-3 py-3 bg-gray-100">
                                <h1 class="font-semibold">${data.kode_ruangan}</h1>
                                <p class="font-light">Ruangan</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-green-700 mb-4">
                        Komentar User
                        </h2>
                        @empty($rekomendasi->umpanBalik)
                            <div class="w-full flex flex-col justify-center items-center text-gray-400 bg-gray-100 h-20 border-y-1">
                                <i class="fa-regular fa-pen-to-square text-lg mb-1"></i>
                                <p>Belum ada feedback dari user</p>
                            </div>
                        @endempty
                    </div>`;

                document.getElementById('detail-content').innerHTML = html;
            });
        }

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

                    if (typeof initTambahKomentarValidasi === "function") {
                        initTambahKomentarValidasi();
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

    </script>
@endpush