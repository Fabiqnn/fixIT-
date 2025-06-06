<header class="sticky top-0 z-50 bg-white">
    <div class="w-full max-w-[1400px] mx-auto flex justify-between items-center px-20 py-2 transition-all duration-200 ease-in-out"
        id="header">
        <!-- Logo Kiri -->
        <div class="logo flex items-center gap-2">
            <img src="{{ asset('assets/mechanic-hijau-tua.png') }}" alt="logo" class="h-12 w-auto object-contain">
            <a href="{{ url('/') }}" class="font-glacial text-[25px] font-bold text-gray-800">fixIT!</a>
        </div>
        <!-- Menu Kanan -->
        <ul class="flex gap-6 font-medium items-center font-inter">
            <li><a href="{{ url('/') }}" class="hover:text-D_grey">Beranda</a></li>

            <!-- Dropdown Menu -->
            <li class="relative group">
                <button id="dropdownToggle" class="hover:text-D_grey focus:outline-none cursor-pointer">Menu</button>
                <ul id="dropdownMenu"
                    class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden group-focus-within:block z-50">
                    <li><a href="{{ url('/pelaporan') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Pelaporan</a></li>
                    <li><a href="{{ url('/laporan') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Status Pelaporan</a></li>
                </ul>
            </li>


            <li><a href="{{ url('/panduan') }}" class="hover:text-D_grey">Panduan</a></li>

            <li>
                @if (Auth::check())
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button id="userDropdownToggle"
                            class=" text-white px-4 py-1 rounded text-left leading-tight focus:outline-none flex gap-4 cursor-pointer">
                            @if ($authUser->foto)
                                <img src="{{ asset('uploads/foto/' . $authUser->foto) }}"
                                    class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow">
                            @else
                                <img src="{{ asset('uploads/foto/default-avatar.jpg') }}" alt="Default Avatar"
                                    class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow">
                            @endif
                            <div>
                                <div class="text-sm font-semibold text-black/80">{{ Auth::user()->nama_lengkap }}</div>
                                <div class="text-xs text-black/80">{{ Auth::user()->no_induk }}</div>
                            </div>


                        </button>
                        <ul id="userDropdownMenu"
                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50 ">
                            <li>
                                <a href="{{ url('/profile') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 cursor-pointer">Profil</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 cursor-pointer">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ url('login') }}"
                        class="bg-greenPrimary text-white px-4 py-1 rounded hover:bg-greenshade1 transition inline-block">
                        Masuk
                    </a>
                @endif
            </li>
            <li>

            </li>
        </ul>
    </div>
</header>

@push('js')
    <script>
        $(document).ready(function() {
            const header = document.getElementById('header');
            let isScrolled = true;
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

            document.addEventListener('click', function(e) {
                if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });

            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                menu.classList.toggle('hidden');
            });

            // User dropdown
            const userToggle = document.getElementById('userDropdownToggle');
            const userMenu = document.getElementById('userDropdownMenu');

            document.addEventListener('click', function(e) {
                if (!userToggle.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });

            if (userToggle) {
                userToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    userMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
@endpush
