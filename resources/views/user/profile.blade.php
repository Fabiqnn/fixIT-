@extends('layouts_user.template')

@section('title', 'Profile')

@section('content')
<div class="max-w-5xl mx-auto mb-10 mt-10 bg-white shadow-md rounded-lg overflow-hidden min-h-[600px]">

    <!-- Header / Cover -->
    <div class="relative bg-green-700 h-40 flex items-center justify-center">
        <!-- Dekorasi Lingkaran -->
        <div class="absolute right-10 bottom-4 w-32 h-32 rounded-full border-4 border-yellow-400"></div>
        <div class="absolute right-24 bottom-8 w-24 h-24 rounded-full border-4 border-rose-400"></div>

        <!-- Foto Profil -->
        <div class="absolute -bottom-12 left-10">
            <div class="w-24 h-24 rounded-full bg-gray-300 border-4 border-white"></div>
        </div>
    </div>

    <!-- Body Konten -->
    <div class="pt-16 px-10 pb-10">
        <!-- Nama dan Jabatan -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Masadi</h1>
            <p class="text-gray-500">Mahasiswa</p>
        </div>

        <!-- Info Kontak -->
        <div class="flex flex-wrap gap-6 text-sm text-gray-800">
            <div class="flex items-center gap-2">
                <span class="text-orange-500">
                    <!-- Icon -->
                </span>
                <span>TI 2F</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-orange-500">
                    <!-- Icon -->
                </span>
                <span>+12 345 6789 0</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-orange-500">
                    <!-- Icon -->
                </span>
                <span>gorjezmommy@gmail.com</span>
            </div>
        </div>
    </div>
</div>
@endsection
