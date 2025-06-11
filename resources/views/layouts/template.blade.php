<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'fixIT')</title>

    {{-- Tailwind + Vite --}}
    @vite('resources/css/app.css')

    {{-- Font-Awesome & DataTables --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
</head>

<body class="bg-white h-screen">
    <div class="flex h-full">
        @include('layouts.sidebar')

        {{-- overlay – hanya di mobile --}}
        <div id="overlay"
             class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none
                    transition-opacity duration-300 sm:hidden"></div>

        {{-- konten utama --}}
        <div id="mainContent"
             class="flex-1 flex flex-col transition-all duration-300 sm:ml-64 ml-0">
            @include('layouts.header')

            <main class="h-screen m-2 border border-gray-300 p-6 rounded-lg shadow-md font-inter overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- LIBRARY JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- AJAX CSRF --}}
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
    </script>

    {{-- === SIDEBAR & RESPONSIVE HANDLER === --}}
    <script>
        const sidebar   = document.getElementById('sidebar');
        const main      = document.getElementById('mainContent');
        const overlay   = document.getElementById('overlay');
        const toggleBtn = document.getElementById('toggleSidebar');

        /** Buka / tutup sidebar */
        function setSidebar(open) {
            const isDesktop = window.innerWidth >= 640;

            if (open) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('opacity-0', 'pointer-events-none');

                /* Beri margin di desktop */
                if (isDesktop) main.classList.add('sm:ml-64');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0', 'pointer-events-none');

                /* Hapus margin di desktop */
                main.classList.remove('sm:ml-64');
            }
        }

        /** Dropdown di sidebar (gedung / lantai / dst.) */
        function toggleMenu(menuId) {
            const menu   = document.getElementById(menuId);
            const parent = menu.closest('.group');
            menu.classList.toggle('hidden');
            parent.classList.toggle('open');
        }

        /** Set item aktif di sidebar */
        function setActive(el) {
            document.querySelectorAll('#sidebar a')
                    .forEach(a => a.classList.remove('bg-green-600', 'text-white'));
            el.classList.add('bg-green-600', 'text-white');
        }

        /* ===================== INIT ===================== */
        document.addEventListener('DOMContentLoaded', () => {
            /* Mobile: sidebar tertutup saat awal buka */
            if (window.innerWidth < 640) setSidebar(false);
        });

        /* ===================== EVENTS =================== */
        toggleBtn?.addEventListener('click', () => {
            const closed = sidebar.classList.contains('-translate-x-full');
            setSidebar(closed);
        });

        overlay.addEventListener('click', () => setSidebar(false));

        /* Tutup sidebar otomatis ketika resize ke mobile */
        window.addEventListener('resize', () => {
            if (window.innerWidth < 640) setSidebar(false);
        });
    </script>

    @stack('js')
</body>
</html>
