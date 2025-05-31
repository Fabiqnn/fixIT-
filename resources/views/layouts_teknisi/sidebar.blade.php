<aside id="sidebar"
    class="absolute sm:fixed w-64 h-screen overflow-y-auto bg-white py-2 px-5 space-y-4 transition-transform duration-300 translate-x-0 z-50 ">

    <div class="logo flex items-center gap-2 h-12">
        <img src="{{ asset('assets/mechanic-hijau-tua.png') }}" alt="logo" class="h-12 w-auto object-contain">
        <a href="#" class="text-lg font-bold text-gray-800">fixIT!</a>
    </div>

    <ul class="space-y-2 mt-4 text-gray-700 font-medium">

        <li>
            <a href="{{ url('teknisi/') }}"
                class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'dashboard' ? 'bg-green-600 text-white' : '' }}">
                <i class="fa-solid fa-chart-pie w-5"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ url('teknisi/tugasDiproses') }}"
                class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'tugasDiproses' ? 'bg-green-600 text-white' : '' }}">
                <i class="fa-solid fa-cart-shopping w-5"></i>
                Tugas Diproses
            </a>
        </li>

        <li>
            <a href="{{ url('teknisi/selesai') }}"
                class="flex items-center gap-2 px-3 py-2 hover:bg-green-600 hover:text-white rounded {{ $activeMenu == 'selesai' ? 'bg-green-600 text-white' : '' }}">
                <i class="fa-solid fa-chart-line w-5"></i>
                Tugas Selesai
            </a>
        </li>

        <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center gap-2 px-3 py-2 hover:bg-red-600 hover:text-white rounded">
                <i class="fa-solid fa-right-from-bracket w-5"></i>
                Keluar
            </a>
        </li>

    </ul>
</aside>
