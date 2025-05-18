<header class="sticky top-0 bg-white flex justify-between items-center py-6 px-6 transition-all duration-200 ease-in-out">
    <!-- Logo Kiri -->
    <div class="logo flex items-center gap-2">
        <img src="{{ asset('assets/mechanic-hijau-tua.png') }}" alt="logo" class="h-12 w-auto object-contain">
        <a href="{{ url('/')}}" class="font-glacial text-[25px] font-bold text-gray-800">fixIT!</a>
    </div>

    <!-- Menu Kanan -->
    <ul class="flex gap-6 font-medium items-center font-inter ">
        <li><a href="{{ url('/')}}" class="hover:text-D_grey">Beranda</a></li>
        <li class="relative group">
            <button id="dropdownToggle" class="hover:text-D_grey focus:outline-none">
                Menu
            </button>
        
            <!-- Dropdown Menu -->
            <ul id="dropdownMenu"
                class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden group-focus-within:block">
                <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Pelaporan</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Riwayat</a></li>
            </ul>
        </li>
        
        <li><a href="#" class="hover:text-D_grey">Panduan</a></li>
        <li>
            <button class="bg-greenPrimary text-white px-4 py-1 rounded hover:bg-greenshade1 transition">
                Masuk
            </button>
        </li>
    </ul>
</header>

@push('js')
    <script>
        $(document).ready(function () {
            const header = document.querySelector('header');
            let isScrolled = true;
            window.addEventListener('scroll', function() {
                if (window.scrollY > 20 && !isScrolled) {
                    header.classList.add('py-4');
                    header.classList.remove('py-6');
                    isScrolled = true;
                } else if(window.scrollY <= 20 && isScrolled) {
                    header.classList.remove('py-4');
                    header.classList.add('py-6')
                    isScrolled = false
                }
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('dropdownToggle');
        const menu = document.getElementById('dropdownMenu');

        document.addEventListener('click', function (e) {
            // Klik di luar menu = tutup menu
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            menu.classList.toggle('hidden');
        });
    });
    </script>
@endpush

