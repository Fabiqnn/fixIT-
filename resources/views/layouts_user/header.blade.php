<header class="sticky top-0 z-50 bg-white shadow-md">
    <div class="w-full max-w-[1400px] mx-auto flex justify-between items-center px-4 sm:px-8 md:px-12 lg:px-20 py-2 transition-all duration-200 ease-in-out"
        id="header">
        <div class="logo flex items-center gap-1 sm:gap-2">
            <img src="{{ asset('assets/mechanic-hijau-tua.png') }}" alt="logo" class="h-9 sm:h-10 md:h-12 w-auto object-contain">
            <a href="{{ url('/') }}" class="font-glacial text-[22px] sm:text-[24px] md:text-[25px] font-bold text-gray-800">fixIT!</a>
        </div>
        {{-- Default flex for larger screens, but allows wrapping and smaller gaps on smaller screens --}}
        <ul class="flex flex-wrap justify-end gap-3 sm:gap-4 lg:gap-6 font-medium items-center font-inter">
            <li><a href="{{ url('/') }}" class="text-sm sm:text-base hover:text-D_grey whitespace-nowrap">Beranda</a></li>

            <li class="relative group">
                <button id="dropdownToggle" class="text-sm sm:text-base hover:text-D_grey focus:outline-none cursor-pointer whitespace-nowrap">Menu</button>
                <ul id="dropdownMenu"
                    class="absolute right-0 mt-2 w-32 sm:w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block group-focus-within:block z-50">
                    <li><a href="{{ url('/pelaporan') }}"
                                class="block px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">Pelaporan</a></li>
                    <li><a href="{{ url('/laporan') }}"
                                class="block px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">Status Pelaporan</a></li>
                </ul>
            </li>

            <li><a href="{{ url('/panduan') }}" class="text-sm sm:text-base hover:text-D_grey whitespace-nowrap">Panduan</a></li>

            <li>
                @if (Auth::check())
                    <div class="relative group">
                        <button id="userDropdownToggle"
                            class="text-white px-2 py-1 rounded text-left leading-tight focus:outline-none flex gap-2 sm:gap-4 items-center cursor-pointer">
                            @if ($authUser->foto)
                                <img src="{{ asset('uploads/foto/' . $authUser->foto) }}"
                                    class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full object-cover border border-gray-300 shadow">
                            @else
                                <img src="{{ asset('uploads/foto/default-avatar.jpg') }}" alt="Default Avatar"
                                    class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full object-cover border border-gray-300 shadow">
                            @endif
                            {{-- User name and ID will hide on extra small screens (below sm breakpoint) to save space --}}
                            <div class="hidden sm:block">
                                <div class="text-xs sm:text-sm font-semibold text-black/80 whitespace-nowrap">{{ Auth::user()->nama_lengkap }}</div>
                                <div class="text-xs text-black/80 whitespace-nowrap">{{ Auth::user()->no_induk }}</div>
                            </div>
                        </button>
                        <ul id="userDropdownMenu"
                            class="absolute right-0 mt-2 w-32 sm:w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50 ">
                            <li>
                                <a href="{{ url('/profile') }}"
                                    class="block px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm text-gray-700 hover:bg-gray-100 cursor-pointer whitespace-nowrap">Profil</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm text-red-600 hover:bg-gray-100 cursor-pointer whitespace-nowrap">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ url('login') }}"
                        class="bg-greenPrimary text-white px-3 py-1 sm:px-4 sm:py-1 rounded hover:bg-greenshade1 transition inline-block text-sm whitespace-nowrap">
                        Masuk
                    </a>
                @endif
            </li>
            <li>
                {{-- This empty li seems intentional, keeping it --}}
            </li>
        </ul>
    </div>
</header>

@push('js')
<script>
    $(document).ready(function() {
        const header = document.getElementById('header');
        // Initial state for header padding
        let isScrolled = false; // Changed to false assuming header starts in 'py-4' state
        // Check initial scroll position in case user refreshes scrolled down
        if (window.scrollY > 20) {
            header.classList.add('py-2');
            header.classList.remove('py-4');
            isScrolled = true;
        } else {
            header.classList.remove('py-2');
            header.classList.add('py-4');
            isScrolled = false;
        }

        window.addEventListener('scroll', function() {
            if (window.scrollY > 20 && !isScrolled) {
                header.classList.add('py-2');
                header.classList.remove('py-4');
                isScrolled = true;
            } else if (window.scrollY <= 20 && isScrolled) {
                header.classList.remove('py-2');
                header.classList.add('py-4');
                isScrolled = false;
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Main menu dropdown
        const toggle = document.getElementById('dropdownToggle');
        const menu = document.getElementById('dropdownMenu');

        if (toggle && menu) { // Ensure elements exist before adding listeners
            document.addEventListener('click', function(e) {
                if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });

            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                menu.classList.toggle('hidden');
            });
        }

        // User dropdown
        const userToggle = document.getElementById('userDropdownToggle');
        const userMenu = document.getElementById('userDropdownMenu');

        if (userToggle && userMenu) { // Ensure elements exist before adding listeners
            document.addEventListener('click', function(e) {
                if (!userToggle.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });

            userToggle.addEventListener('click', function(e) {
                e.preventDefault();
                userMenu.classList.toggle('hidden');
            });
        }
    });
</script>
@endpush