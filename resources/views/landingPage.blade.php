@extends('layouts_user.template')

@section('title', 'Landing Page | fixIT!')

@section('content')
    {{-- Card 1: Hero Section --}}
    <div name="card1" class="bg-silver w-full fade-in">
        <div class="flex flex-col md:flex-row items-center justify-between px-5 md:px-20 py-20 md:py-40 w-full max-w-[1400px] mx-auto autoShow1">
            <div class="space-y-2 tracking-wide text-center md:text-left mb-10 md:mb-0">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-D_grey">Lapor Mudah,</h1>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-greenPrimary">Fasilitas Terjaga!</h1>
                <h5 class="text-base sm:text-lg mt-5">Mari bersama wujudkan kampus yang lebih baik dengan fixIT!</h5>
            </div>
            <div class="w-full md:w-1/2 flex justify-center md:justify-end">
                <img src="{{ asset('assets/landingpage1.png')}}" alt="" class="h-auto w-4/5">
            </div>
        </div>
    </div>

    {{-- Card 2: Main Features Section --}}
    <div name="card2" class="p-10 md:p-20 w-full max-w-[1400px] mx-auto">
        <div class="text-center autoShow">
            <h1 class="font-bold text-3xl sm:text-4xl text-D_grey">Fitur Utama Pada Sistem fixIT!</h1>
            <h4 class="text-base sm:text-lg mt-2">Yuk kenalan dengan fitur-fitur utama fixIT!</h4>
        </div>
        <div class="flex flex-col md:flex-row text-center space-y-10 md:space-y-0 md:space-x-10 mt-10 md:mt-20 autoShow2">
            <div class="w-full md:w-1/3 shadow-sm rounded space-y-5 px-3 py-5">
                <i class="fa-solid fa-clipboard fa-2xl mt-5"></i>
                <h1 class="text-D_grey font-bold text-xl sm:text-2xl mt-5">Pelaporan <br> Kerusakan Fasilitas</h1>
                <p class="text-sm sm:text-base">Menjadikan fixIT! sebagai platform laporan kerusakan fasilitas sehingga bisa diproses lebih cepat.</p>
            </div>
            <div class="w-full md:w-1/3 shadow-sm rounded space-y-5 px-3 py-5">
                <i class="fa-regular fa-clock fa-2xl mt-5"></i>
                <h1 class="text-D_grey font-bold text-xl sm:text-2xl mt-5">Update Perbaikan <br> Secara Real-time</h1>
                <p class="text-sm sm:text-base">Memungkinkan untuk bisa memantau perkembangan dari fasilitas yang sedang diperbaiki dan ketersediaan fasilitas.</p>
            </div>
            <div class="w-full md:w-1/3 shadow-sm rounded space-y-5 px-3 py-5">
                <i class="fa-solid fa-comment fa-2xl mt-5"></i>
                <h1 class="text-D_grey font-bold text-xl sm:text-2xl mt-5">Memberikan <br>Feedback</h1>
                <p class="text-sm sm:text-base">Memberikan feedback atau masukan terhadap pelaksanaan perbaikan dan fasilitas lainnya</p>
            </div>
        </div>
    </div>

    {{-- Card 3: About Section --}}
    <div name="card3" class="p-10 md:p-20 flex flex-col md:flex-row items-center gap-5 w-full max-w-[1400px] mx-auto autoShow2">
        <div class="w-full md:w-1/2 mb-10 md:mb-0">
            <img src="{{ asset('assets/landingpage2.png') }}" alt="" class="w-full h-auto">
        </div>
        <div class="space-y-5 text-center md:text-left w-full md:w-1/2">
            <h1 class="text-D_grey font-bold text-3xl sm:text-4xl">About fixIT!</h1>
            <p class="text-sm sm:text-base">fixIT! Merupakan sistem pelaporan sarana prasarana yang dirancang untuk mempermudah dosen maupun mahasiswa untuk melaporkan kerusakan sarana dan prasarana didalam lingkup kampus Politeknik Negeri Malang. fixIT! Merupakan sistem yang memungkinkan mahasiswa maupun dosen bisa memantau perkembangan maupun ketersediaan sarana dan prasarana didalam kampus Politeknik Negeri Malang.</p>
        </div>
    </div>

    {{-- Stats Section --}}
    <div class="bg-silver">
        <div class="flex flex-col md:flex-row p-10 md:p-20 justify-between items-center w-full max-w-[1400px] mx-auto autoShow">
            <div class="text-center md:text-left mb-10 md:mb-0">
                <h1 class="text-3xl sm:text-4xl font-bold text-D_grey">Bersama, Rawat Kampus</h1>
                <h1 class="text-3xl sm:text-4xl font-bold text-greenPrimary">Menjadi Lebih Baik</h1>
                <p class="text-base sm:text-lg">Perbaiki bersama, wujudkan lingkungan kampus yang ideal.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-10 md:gap-3">
                <div class="flex items-center gap-3">
                    <div>
                        <i class="fa-solid fa-users fa-2xl" style="color: #4caf4f;"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-D_grey">20</h1>
                        <h5 class="text-sm sm:text-base">Unit Pengelola</h5>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-5 sm:mt-0">
                    <div>
                        <i class="fa-solid fa-clipboard-check fa-2xl" style="color: #4caf4f;"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-D_grey">402</h1>
                        <h5 class="text-sm sm:text-base">Laporan Kerusakan</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Call to Action Section --}}
    <div class="bg-silver">
        <div class="p-10 md:p-20 space-y-3 w-full max-w-[1400px] mx-auto text-center md:text-left autoShow2">
            <h1 class="text-3xl sm:text-4xl font-bold text-D_grey">Kampus lebih baik dimulai dari langkah kecil.</h1>
            <h4 class="text-lg sm:text-xl">Yuk, mulai dari laporanmu hari ini!.</h4>
            <a href="{{ url('login') }}" class="bg-greenPrimary text-white px-6 py-2 rounded hover:bg-greenshade1 transition inline-block text-base">
                Ingin Melapor?
            </a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add the 'visible' class to trigger the fade-in effect
            document.querySelectorAll('.fade-in').forEach(function(element) {
                element.classList.add('visible');
            });
        });
    </script>
@endsection