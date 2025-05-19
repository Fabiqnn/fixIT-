@extends('layouts_user.template')

@section('title', 'Landing Page | fixIT!')

@section('content')
    <div name="card1" class="bg-silver w-full">
        <div class="flex items-center justify-between px-20 py-40 w-full max-w-[1400px] mx-auto">
            <div class="space-y-2 tracking-wide">
                <h1 class="text-6xl font-bold text-D_grey">Lapor Mudah,</h1>
                <h1 class="text-6xl font-bold text-greenPrimary">Fasilitas Terjaga!</h1>
                <h5 class="text-lg mt-5">Mari bersama wujudkan kampus yang lebih baik dengan fixIT!</h5>
                <button class="bg-greenPrimary text-white px-10 py-3 rounded hover:bg-greenshade1 transition items-center text-lg">Masuk</button>
            </div>
            <div class="w-full md:w-1/2 flex justify-center">
                <img src="{{ asset('assets/landingpage1.png')}}" alt="" class="h-auto w-3/4">
            </div>
        </div>
    </div>

    <div name="card2" class="p-20 w-full max-w-[1400px] mx-auto">
        <div class="text-center">
            <h1 class="font-bold text-4xl text-D_grey">Fitur Utama Pada Sistem fixIT!</h1>
            <h4>Yuk kenalan dengan fitur-fitur utama fixIT!</h4>
        </div>
        <div class="flex text-center space-x-10 mt-20">
            <div class="w-1/3 shadow-sm rounded space-y-5 px-3 py-5 ">
                <i class="fa-solid fa-clipboard fa-2xl mt-5"></i>
                <h1 class="text-D_grey font-bold text-2xl mt-5">Pelaporan <br> Kerusakan Fasilitas</h1>
                <p>Menjadikan fixIT! sebagai platform laporan kerusakan fasilitas sehingga bisa diproses lebih cepat.</p>
            </div>
            <div class="w-1/3 shadow-sm rounded space-y-5 px-3 py-5">
                <i class="fa-regular fa-clock fa-2xl mt-5"></i>
                <h1 class="text-D_grey font-bold text-2xl mt-5">Update Perbaikan <br> Secara Real-time</h1>
                <p>Memungkinkan untuk bisa memantau perkembangan dari fasilitas yang sedang diperbaiki dan ketersediaan
                    fasilitas.</p>
            </div>
            <div class="w-1/3 shadow-sm rounded space-y-5 px-3 py-5">
                <i class="fa-solid fa-comment fa-2xl mt-5"></i>
                <h1 class="text-D_grey font-bold text-2xl mt-5">Memberikan <br>Feedback</h1>
                <p>Memberikan feedback atau masukan terhadap pelaksanaan perbaikan dan fasilitas lainnya</p>
            </div>
        </div>
    </div>

    <div name="card3" class="p-20 flex items-center gap-5 w-full max-w-[1400px] mx-auto">
        <div>
            <img src="{{ asset('assets/landingpage2.png') }}" alt="">
        </div>
        <div class="space-y-5">
            <h1 class="text-D_grey font-bold text-4xl">About fixIT!</h1>
            <p>fixIT! Merupakan sistem pelaporan sarana prasarana yang dirancang untuk mempermudah dosen maupun mahasiswa
                untuk melaporkan kerusakan sarana dan prasarana didalam lingkup kampus Politeknik Negeri Malang.
                fixIT! Merupakan sistem yang memungkinkan mahasiswa maupun dosen bisa memantau perkembangan maupun
                ketersediaan sarana dan prasarana didalam kampus Politeknik Negeri Malang.</p>
        </div>
    </div>

    <div class="bg-silver">
        <div class="flex p-20 justify-between w-full max-w-[1400px] mx-auto">
            <div>
                <h1 class="text-4xl font-bold text-D_grey">Bersama, Rawat Kampus</h1>
                <h1 class="text-4xl font-bold text-greenPrimary">Menjadi Lebih Baik</h1>
                <p>Perbaiki bersama, wujudkan lingkungan kampus yang ideal.</p>
            </div>
            <div class="flex items-center gap-3">
                <div>
                    <i class="fa-solid fa-users fa-2xl" style="color: #4caf4f;"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-D_grey">20</h1>
                    <h5>Unit Pengelola</h5>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div>
                    <i class="fa-solid fa-clipboard-check fa-2xl" style="color: #4caf4f;"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-D_grey">402</h1>
                    <h5>Laporan Kerusakan</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-silver">
        <div class="p-20 space-y-3 w-full max-w-[1400px] mx-auto">
            <h1 class="text-4xl font-bold text-D_grey">Kampus lebih baik dimulai dari langkah kecil.</h1>
            <h4 class="text-xl">Yuk, mulai dari laporanmu hari ini!.</h4>
            <button class="bg-greenPrimary text-white px-[16px] py-[8px] rounded hover:bg-greenshade1 transition items-center mt-5">Masuk</button>
        </div>
    </div>
@endsection
