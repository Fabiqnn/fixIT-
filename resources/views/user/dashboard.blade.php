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

    <!-- Search & Filter -->
    <div class="mx-3 mb-5">
        <div class="flex gap-5 items-center">
            <div class="relative w-full max-w-md">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-700 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" id="search" placeholder="Search"
                    class="pl-10 w-full py-2 bg-gray-100 rounded focus:outline-none focus:ring-2 focus:ring-green-700 text-sm placeholder:text-green-700" />
            </div>
            <div>
                <select id="gedung_id" name="gedung_id"
                    class="border border-green-700 rounded text-gray-700 p-2 outline-none">
                    <option value="">- Filter -</option>
                    {{-- @foreach ($gedung as $g)
                        <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                    @endforeach --}}
                </select>
            </div>
        </div>
    </div>

    <!-- Sidebar & Detail Panel -->
    <div class="h-[calc(100vh-14rem)] mx-3 border border-gray-300 p-0 rounded-lg shadow-md flex overflow-hidden">
        <!-- Sidebar -->
        <div class="w-1/3 max-w-sm bg-white flex flex-col h-full">
            <div class="p-4 border-b font-semibold text-green-700 text-lg">Menu</div>
            <ul id="menuList" class="flex-1 overflow-y-auto divide-y divide-gray-200">
                @for ($i = 1; $i <= 30; $i++)
                    <li onclick="showDetail('item{{ $i }}')" class="cursor-pointer hover:bg-green-50 px-5 py-4 transition-colors">
                        <div class="font-medium">Item {{ $i }}</div>
                        <div class="text-sm text-gray-500">Deskripsi singkat item {{ $i }}</div>
                    </li>
                @endfor
            </ul>
        </div>

        <!-- Detail Panel -->
        <div class="flex-1 bg-gray-50 p-6 overflow-y-auto h-full">
            @for ($i = 1; $i <= 30; $i++)
                <div id="item{{ $i }}" class="hidden">
                    <h2 class="text-2xl font-semibold text-green-700 mb-4">Detail Item {{ $i }}</h2>
                    <p class="text-gray-700 leading-relaxed">Informasi lengkap mengenai item {{ $i }} akan ditampilkan di sini.</p>
                </div>
            @endfor
            <div id="placeholder" class="flex flex-col justify-center items-center text-gray-400 h-full">
                <i class="fa-regular fa-hand-pointer text-4xl mb-4"></i>
                <p class="text-lg">Pilih salah satu item dari menu di kiri.</p>
            </div>
        </div>
    </div>

    <script>
        function showDetail(itemId) {
            const allItems = document.querySelectorAll('[id^="item"]');
            allItems.forEach(div => div.classList.add('hidden'));
            document.getElementById('placeholder').classList.add('hidden');
            document.getElementById(itemId).classList.remove('hidden');
        }
    </script>
@endsection
