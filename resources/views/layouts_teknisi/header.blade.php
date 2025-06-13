<header class="bg-white p-4 flex items-center gap-4 h-16">
    <button id="toggleSidebar"
        class="text-2xl focus:outline-none hover:bg-gray-200 hover:bg-opacity-50 cursor-pointer p-2 rounded transition sm:hidden">
        ☰
    </button>
    <h1 class="text-xl font-semibold">@yield('header', 'Dashboard')</h1>

      <ul class="flex gap-4 ml-auto">
        <li class="flex items-center gap-2">
            <a href="{{ url('teknisi/profile') }}"
               class="flex items-center gap-2 hover:opacity-80 transition">
                {{-- Foto selalu tampil --}}
                <img src="{{ $authUser->foto
                            ? asset('uploads/foto/'.$authUser->foto)
                            : asset('uploads/foto/default-avatar.jpg') }}"
                     class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow">

                {{-- Nama + role: disembunyikan < md --}}
                <div class="hidden md:flex flex-col leading-tight text-sm">   {{-- **UPDATED** --}}
                    <span class="font-semibold text-gray-800">
                        {{ $authUser->nama_lengkap ?? 'Guest' }}
                    </span>
                    <span class="text-gray-500">
                        {{ $authUser->level->level_nama ?? 'Tidak diketahui' }}
                    </span>
                </div>
            </a>
        </li>
    </ul>
</header>
