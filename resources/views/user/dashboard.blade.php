@extends('layouts_user.template')

@section('title', 'Dashboard Mahasiswa | fixIT!')

@section('content')
<!-- Header -->
<div class="w-full h-40 px-3 mb-5 fade-in">
    <div class="w-full h-full relative">
        <img src="{{ asset('assets/bg1.jpg') }}" alt="" class="h-full w-full object-cover rounded-b-lg">
        <div class="bg-black/50 h-full w-full absolute top-0 left-0 rounded-b-lg"></div>
        <div class="absolute inset-0 flex items-center pl-5">
            <h1 class="text-white font-semibold text-xl sm:text-2xl tracking-wide">Dashboard</h1>
        </div>
    </div>
</div>

<!-- Sidebar & Detail Panel -->
<div class="h-auto lg:h-[calc(100vh-14rem)] mx-3 border border-gray-300 p-0 rounded-lg shadow-md flex flex-col lg:flex-row overflow-hidden mb-5 fade-in">
    <!-- Sidebar -->
    <div class="w-full lg:w-1/3 max-w-full bg-white flex flex-col h-full">
        <div class="flex justify-between border-b flex-wrap">
            <div class="p-4 font-semibold text-green-700 text-lg">Menu</div>
            <div class="my-auto mr-3 mb-2 lg:mb-0">
                <select id="periode_id" name="periode_id"
                    class="border border-green-700 rounded text-gray-700 p-2 outline-none">
                    <option value="">- Filter -</option>
                    @foreach ($periode as $p)
                        <option value="{{ $p->periode_id }}">{{ $p->nama_periode }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <ul id="menuList" class="flex-1 overflow-y-auto divide-y divide-gray-200 max-h-[60vh] lg:max-h-full">
            @forelse ($rekomendasi as $item)
                @if($item->alternatif)
                    <li onclick="loadItem({{ $item->rekomendasi_id }}, this)" 
                        class="cursor-pointer hover:bg-green-50 px-5 py-4 transition-colors space-y-3" 
                        data-periode-id="{{ $item->periode_id }}">

                        <!-- Konten utama item -->
                        <div class="font-medium">{{ $item->alternatif->laporan->fasilitas->nama_fasilitas }}</div>

                        <!-- Status & Lokasi -->
                        <div class="flex flex-col sm:flex-row justify-between gap-2">
                            <div class="px-3 py-1 rounded-2xl {{ $item->alternatif->laporan->status_perbaikan == 'tuntas' ? 'bg-success' : 'bg-info' }} text-white text-sm text-center w-fit">
                                {{ ucfirst($item->alternatif->laporan->status_perbaikan) }}
                            </div>
                            <ul class="flex flex-wrap font-light text-sm space-x-3">
                                <li>{{ $item->alternatif->laporan->fasilitas->ruangan->gedung->gedung_nama }}</li>
                                <li>{{ $item->alternatif->laporan->fasilitas->ruangan->lantai->nama_lantai }}</li>
                                <li>{{ $item->alternatif->laporan->fasilitas->ruangan->kode_ruangan }}</li>
                            </ul>
                        </div>

                        <!-- Detail untuk Mobile -->
                        <div class="mobile-detail hidden lg:hidden mt-3 text-sm text-gray-700"></div>
                    </li>
                @endif
            @empty
                <div class="flex flex-col justify-center items-center text-gray-400 h-full py-5">
                    <i class="fa-regular fa-face-sad-tear text-4xl mb-4"></i>
                    <p class="text-sm">Belum ada fasilitas yang dikerjakan oleh teknisi</p>
                </div>
            @endforelse
        </ul>
    </div>

    <!-- Detail Panel -->
    <div id="detail-panel" class="flex-1 bg-gray-50 p-4 sm:p-6 overflow-y-auto h-full fade-in">
        <div id="detail-placeholder" class="flex flex-col justify-center items-center text-gray-400 h-full">
            <i class="fa-regular fa-hand-pointer text-4xl mb-4"></i>
            <p class="text-lg">Pilih salah satu item dari menu.</p>
        </div>
        <div id="detail-content" class="pt-4"></div>
    </div>
</div>

<!-- Modal -->
<div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden overflow-auto">
    <div class="bg-white rounded shadow-lg w-[95%] sm:w-[90%] md:w-4/5 lg:max-w-4xl relative my-10 sm:my-auto" id="modal-box">
        <button onclick="closeModal()"
            class="absolute top-4 right-6 text-white hover:text-gray-700 text-2xl font-bold cursor-pointer">
            &times;
        </button>
        <div id="modalContent" class="w-full"></div>
    </div>
</div>

<style>
    .fade-in {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    .fade-in.visible {
        opacity: 1;
    }
</style>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add the 'visible' class to trigger the fade-in effect
        document.querySelectorAll('.fade-in').forEach(function(element) {
            element.classList.add('visible');
        });
    });

    function loadItem(id, el = null) {
        const url = `{{ url('/detail-rekomendasi') }}/` + id;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                const assetBaseFoto = "{{ asset('uploads/foto') }}";

                const detailHtml = `
                    <h2 class="text-2xl sm:text-4xl font-semibold text-green-700 mb-4">
                        Detail Data Perbaikan Fasilitas ${data.fasilitas}
                    </h2>
                    <div class="mb-5 pb-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between gap-4 items-start sm:items-end">
                            <div class="flex space-x-4 items-end">
                                <div class="px-3 py-1 rounded-2xl ${data.status === 'tuntas' ? 'bg-success' : 'bg-info'} text-white text-sm text-center">
                                    <i class="fa-solid fa-check"></i> ${data.status}
                                </div>
                                <p class="font-light">Info Fasilitas</p>
                            </div>
                            ${data.status === 'tuntas' ? `
                                <button class="button1 cursor-pointer outline-none" onclick="modalAction('{{ url('/penilaian/${data.rekomendasi_id}') }}')">
                                    <span class="text-md mr-2"><i class="fa-regular fa-star"></i></span> Beri Penilaian
                                </button>` : `
                                <button class="bg-gray-400 px-3 py-[6px] text-white rounded-sm cursor-pointer outline-none" disabled>
                                    <span class="text-md mr-2"><i class="fa-regular fa-star"></i></span> Beri Penilaian
                                </button>`}
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
                            <div class="shadow-sm rounded px-3 py-3 bg-gray-100">
                                <h1 class="font-semibold">${data.nama_periode}</h1>
                                <p class="font-light">Periode</p>
                            </div>
                            <div class="shadow-sm rounded px-3 py-3 bg-gray-100">
                                <h1 class="font-semibold">${data.gedung}</h1>
                                <p class="font-light">Gedung</p>
                            </div>
                            <div class="shadow-sm rounded px-3 py-3 bg-gray-100">
                                <h1 class="font-semibold">${data.lantai}</h1>
                                <p class="font-light">Lantai</p>
                            </div>
                            <div class="shadow-sm rounded px-3 py-3 bg-gray-100">
                                <h1 class="font-semibold">${data.kode_ruangan}</h1>
                                <p class="font-light">Ruangan</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-green-700 mb-4">Komentar User</h2>
                        ${data.umpan_balik.length === 0 ? `
                            <div class="w-full flex flex-col justify-center items-center text-gray-400 bg-gray-100 h-20 border-y-1">
                                <i class="fa-regular fa-pen-to-square text-lg mb-1"></i>
                                <p>Belum ada feedback dari user</p>
                            </div>` :
                            data.umpan_balik.map(item => {
                                const foto = item.foto_profile ? `${assetBaseFoto}/${item.foto_profile}` : `${assetBaseFoto}/default-avatar.jpg`;
                                const stars = Array.from({length: 5}).map((_, i) =>
                                    `<label class="star text-xl sm:text-2xl text-gray-300 ${i < item.skala_kepuasan ? 'text-yellow-400' : ''}">&#9733;</label>`
                                ).join('');

                                return `
                                <div class="w-full mb-4">
                                    <div class="flex space-x-2 items-center">
                                        <img src="${foto}" class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow">
                                        <p>${item.nama}</p>
                                    </div>
                                    <div class="flex space-x-5 items-center">
                                        <div class="flex space-x-1">${stars}</div>
                                        <p class="text-sm text-gray-500">${item.tanggal}</p>
                                    </div>
                                    <div class="w-full min-h-10 break-words">
                                        <p class="text-gray-700">${item.komentar}</p>
                                    </div>
                                </div>`;
                            }).join('')
                        }
                    </div>
                `;

                if (window.innerWidth < 1024) {
                    // Untuk mobile: tampilkan di dalam item
                    document.querySelectorAll('.mobile-detail').forEach(d => d.innerHTML = '');
                    const detailContainer = el.querySelector('.mobile-detail');
                    detailContainer.innerHTML = detailHtml;
                    detailContainer.classList.remove('hidden');
                } else {
                    // Untuk desktop: tampilkan di panel kanan
                    document.getElementById('detail-placeholder').style.display = 'none';
                    document.getElementById('detail-content').innerHTML = detailHtml;
                }
                
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


