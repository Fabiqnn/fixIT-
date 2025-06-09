<header
  id="header"
  class="sticky top-0 z-50 bg-white shadow-md transition-transform duration-300 ease-in-out py-4 origin-top"
>
  <div class="w-full max-w-[1400px] mx-auto flex justify-between items-center px-4 sm:px-8 md:px-12 lg:px-20"
       id="header-content">

    <div class="flex items-center gap-2">
        <a href="{{url('/')}}">
      <img src="{{ asset('assets/mechanic-hijau-tua.png') }}" alt="logo"
           class="h-9 sm:h-10 md:h-12 w-auto object-contain">
        </a>
        
      <a href="{{ url('/') }}"
         class="hidden sm:block font-glacial text-[22px] sm:text-[24px] md:text-[25px] font-bold text-gray-800">
         fixIT!
      </a>

      <div class="block sm:hidden relative ml-2">
        <button id="hamburgerToggle">
          <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>

        {{-- Dropdown hamburger --}}
        <ul id="hamburgerMenu"
            class="fixed top-[60px] left-0 w-screen bg-white border-t border-gray-200 shadow-md z-40 hidden flex-col sm:hidden">
          <li><a href="{{ url('/pelaporan') }}"
                 class="block w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">Pelaporan</a></li>
          <li><a href="{{ url('/laporan') }}"
                 class="block w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">Status Pelaporan</a></li>
          <li><a href="{{ url('/panduan') }}"
                 class="block w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">Panduan</a></li>
        </ul>
      </div>
    </div>

    {{-- Menu Utama: hanya di layar besar --}}
    <ul class="hidden sm:flex flex-wrap justify-end gap-4 lg:gap-6 font-medium items-center font-inter">
      <li><a href="{{ url('/pelaporan') }}" class="text-base hover:text-D_grey whitespace-nowrap">Pelaporan</a></li>
      <li><a href="{{ url('/laporan') }}" class="text-base hover:text-D_grey whitespace-nowrap">Status Pelaporan</a></li>
      <li><a href="{{ url('/panduan') }}" class="text-base hover:text-D_grey whitespace-nowrap">Panduan</a></li>

      {{-- Login / User Info --}}
      <li>
        @if (Auth::check())
          <div class="relative group">
            <button id="userDropdownToggle"
                    class="text-white px-2 py-1 rounded text-left leading-tight focus:outline-none flex gap-2 items-center cursor-pointer">
              @if ($authUser->foto)
                <img src="{{ asset('uploads/foto/' . $authUser->foto) }}"
                     class="w-9 h-9 md:w-10 md:h-10 rounded-full object-cover border border-gray-300 shadow">
              @else
                <img src="{{ asset('uploads/foto/default-avatar.jpg') }}"
                     class="w-9 h-9 md:w-10 md:h-10 rounded-full object-cover border border-gray-300 shadow">
              @endif
              <div class="block">
                <div class="text-sm font-semibold text-black/80 whitespace-nowrap">
                  {{ Auth::user()->nama_lengkap }}
                </div>
                <div class="text-xs text-black/80 whitespace-nowrap">
                  {{ Auth::user()->no_induk }}
                </div>
              </div>
            </button>
            <ul id="userDropdownMenu"
                class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
              <li>
                <a href="{{ url('/profile') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
              </li>
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit"
                          class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 cursor-pointer">
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <a href="{{ url('login') }}"
             class="bg-greenPrimary text-white px-4 py-1 rounded hover:bg-greenshade1 transition inline-block text-base whitespace-nowrap">
            Masuk
          </a>
        @endif
      </li>
    </ul>

    {{-- Tombol Profil / Masuk di layar kecil --}}
    <div class="sm:hidden">
        @if (Auth::check())
            <div class="relative inline-block">
            <button id="mobileUserDropdownToggle"
                    class="flex items-center gap-2 px-2 py-1 focus:outline-none">
                @if ($authUser->foto)
                <img src="{{ asset('uploads/foto/' . $authUser->foto) }}"
                    class="w-8 h-8 rounded-full object-cover border border-gray-300 shadow">
                @else
                <img src="{{ asset('uploads/foto/default-avatar.jpg') }}"
                    class="w-8 h-8 rounded-full object-cover border border-gray-300 shadow">
                @endif
            </button>
            <ul id="mobileUserDropdownMenu"
                class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                <li>
                <a href="{{ url('/profile') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                </li>
                <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 cursor-pointer">
                    Logout
                    </button>
                </form>
                </li>
            </ul>
        </div>
    @else
        <a href="{{ url('login') }}"
        class="bg-greenPrimary text-white px-3 py-1 rounded hover:bg-greenshade1 transition text-sm whitespace-nowrap">
        Masuk
        </a>
    @endif
    </div>
  </div>
</header>

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('header');
    const hamburgerToggle = document.getElementById('hamburgerToggle');
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    const mobileUserToggle = document.getElementById('mobileUserDropdownToggle');
    const mobileUserMenu = document.getElementById('mobileUserDropdownMenu');

    //Update posisi dropdown hamburger saat scroll atau resize
    function updateDropdownPosition() {
      const headerHeight = header.offsetHeight;
      hamburgerMenu.style.top = `${headerHeight}px`;
    }

    //Toggle hamburger menu
    hamburgerToggle?.addEventListener('click', () => {
      const isVisible = !hamburgerMenu.classList.contains('hidden');
      if (isVisible) {
        hamburgerMenu.classList.add('hidden');
      } else {
        updateDropdownPosition();
        hamburgerMenu.classList.remove('hidden');
      }
    });

    window.addEventListener('scroll', () => {
      if (!hamburgerMenu.classList.contains('hidden')) {
        updateDropdownPosition();
      }
    });

    window.addEventListener('resize', () => {
      if (!hamburgerMenu.classList.contains('hidden')) {
        updateDropdownPosition();
      }
    });

    //Toggle user dropdown (desktop)
    userDropdownToggle?.addEventListener('click', (e) => {
      e.stopPropagation();
      userDropdownMenu.classList.toggle('hidden');
    });

    //Toggle user dropdown (mobile)
    mobileUserToggle?.addEventListener('click', (e) => {
      e.stopPropagation();
      mobileUserMenu.classList.toggle('hidden');
    });

    //Klik di luar menutup semua dropdown
    document.addEventListener('click', (e) => {
      if (
        !userDropdownToggle?.contains(e.target) &&
        !userDropdownMenu?.contains(e.target)
      ) {
        userDropdownMenu?.classList.add('hidden');
      }

      if (
        !mobileUserToggle?.contains(e.target) &&
        !mobileUserMenu?.contains(e.target)
      ) {
        mobileUserMenu?.classList.add('hidden');
      }
    });

    //Header shrink saat scroll
    function adjustHeaderOnScroll() {
      if (window.scrollY > 20) {
        header.classList.add('scale-y-98');
      } else {
        header.classList.remove('scale-y-98');
      }
    }

    adjustHeaderOnScroll();
    window.addEventListener('scroll', adjustHeaderOnScroll);
  });
</script>
@endpush


