<header class="bg-white p-4 flex items-center gap-4 h-16">
    <button id="toggleSidebar" 
    class="sm:hidden z-50 bg-white p-2 rounded shadow transition-all">
    ☰
</button>


    <h1 class="text-xl font-semibold">@yield('header', 'Dashboard')</h1>

    <ul class="flex gap-4 ml-auto">
        <li class="flex items-center">
            <a href="{{ url('/admin/profile') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                {{-- Foto profil --}}
                @if ($authUser->foto)
                    <img src="{{ asset('uploads/foto/' . $authUser->foto) }}"
                         class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow">
                @else
                    <img src="{{ asset('uploads/foto/default-avatar.jpg') }}" alt="Default Avatar"
                         class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow">
                @endif

                {{-- Nama & role ‒ hanya ≥ md --}}
                <div class="hidden md:flex flex-col leading-tight text-sm">
                    <span class="font-semibold text-gray-800">{{ $authUser->nama_lengkap ?? 'Guest' }}</span>
                    <span class="text-gray-500">{{ $authUser->level->level_nama ?? 'Tidak diketahui' }}</span>
                </div>
            </a>
        </li>
    </ul>
</header>
