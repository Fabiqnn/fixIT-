<aside id="sidebar"
       class="fixed inset-y-0 left-0 w-64 z-50 bg-white overflow-y-auto py-2 px-5 space-y-4
              transform -translate-x-full sm:translate-x-0             {{-- **UPDATED** --}}
              transition-transform duration-300">

    <div class="logo flex items-center gap-2 h-12">
        <img src="{{ asset('assets/mechanic-hijau-tua.png') }}"
             alt="logo" class="h-12 w-auto object-contain">
        <a href="#" class="text-lg font-bold text-gray-800">fixIT!</a>
    </div>

    <ul class="space-y-2 mt-4 text-gray-700 font-medium">
        <li>
            <a href="{{ url('admin/') }}"
                class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'dashboard' ? 'sidebar-active' : '' }}"
                onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#000000">
                    <path
                        d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
                </svg>
                Dashboard
            </a>
        </li>
        <li><a href="{{ url('admin/user') }}"
                class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'user' ? 'sidebar-active' : '' }}"
                onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#000000">
                    <path
                        d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                </svg>
                Pengguna</a></li>
        <li class="relative group">
            <button onclick="toggleMenu('menuBangunan')"
                class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-green-600 cursor-pointer mb-1">
                <span class="flex gap-2 items-center">
                    <div class="w-[24px] text-center">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    Bangunan</span>
                <svg class="w-4 h-4 transform transition-transform group-[.open]:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <!-- Dropdown -->
            <ul id="menuBangunan" class=" mt-1 pl-4 space-y-1">
                <li>
                    <a href="{{ url('admin/gedung') }}"
                        class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'gedung' ? 'sidebar-active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#000000">
                            <path
                                d="M120-120v-560h160v-160h400v320h160v400H520v-160h-80v160H120Zm80-80h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 320h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 480h80v-80h-80v80Zm0-160h80v-80h-80v80Z" />
                        </svg>
                        Gedung</a>
                </li>
                <li>
                    <a href="{{ url('admin/lantai') }}"
                        class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'lantai' ? 'sidebar-active' : '' }}"><i
                            class="fa-solid fa-stairs" style="width: 24px"></i>Lantai</a>
                </li>
                <li>
                    <a href="{{ url('admin/ruangan') }}"
                        class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'ruangan' ? 'sidebar-active' : '' }}"><i
                            class="fa-solid fa-door-open" style="width: 24px"></i>Ruangan</a>
                </li>
                <li><a href="{{ url('admin/fasilitas') }}"
                    class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'fasilitas' ? 'sidebar-active' : '' }}"
                    onclick="setActive(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#000000">
                        <path
                            d="M360-160v-240h240v240H360Zm80-80h80v-80h-80v80ZM88-440l-48-64 440-336 160 122v-82h120v174l160 122-48 64-392-299L88-440Zm392 160Z" />
                    </svg>
                Fasilitas</a></li>
            </ul>
        </li>
        <li><a href="{{ url('admin/periode') }}"
                class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'periode' ? 'sidebar-active' : '' }}"
                onclick="setActive(this)">
                <div class="text-center w-[24px]">
                    <i class="fa-solid fa-clock" style="width: 100%"></i>
                </div>
                Periode</a></li>
        <li><a href="{{ url('admin/pelaporan') }}"
                class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'laporan' ? 'sidebar-active' : '' }}"
                onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#000000">
                    <path
                        d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm200-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-200v-560 560Z" />
                </svg>
                Laporan</a></li>
        <li><a href="{{ url('admin/prioritas') }}"
                class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'prioritas' ? 'sidebar-active' : '' }}"
                onclick="setActive(this)">
                <i class="fa-solid fa-code-commit" style="width: 24px"></i>
                Prioritas Perbaikan</a></li>
        <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center gap-2 px-3 py-2 hover:bg-red-600 hover:text-white rounded">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#000000">
                    <path
                        d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                </svg>
                Keluar
            </a>
        </li>

    </ul>
</aside>