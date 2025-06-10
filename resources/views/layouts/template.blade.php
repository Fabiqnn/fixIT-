<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'fixIT')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
</head>

<body class="bg-white h-screen ">
    <div class="flex h-full">
        @include('layouts.sidebar')

        {{-- Overlay untuk hp --}}
        <div id="overlay" class="fixed inset-0 opacity-50 hidden z-20 sm:hidden"></div>


        <div id="mainContent"
             class="flex-1 flex flex-col ml-0 sm:ml-64 transition-all duration-300">
            @include('layouts.header')

            <main class="h-screen m-2 border border-gray-300 p-6 rounded-lg shadow-md font-inter overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- jquery validation --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="//cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar   = document.getElementById('sidebar');
            const overlay   = document.getElementById('overlay');

            let sidebarVisible = window.innerWidth >= 640;

            function applySidebarState() {
                const isDesktop = window.innerWidth >= 640;
                if (sidebarVisible) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.toggle('hidden', isDesktop); // overlay hanya untuk mobile
                    // Geser tombol hamburger ke kanan saat sidebar terbuka di mobile
                    if (!isDesktop) toggleBtn.classList.add('ml-64');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    toggleBtn.classList.remove('ml-64');
                }
            }

            // Inisialisasi saat halaman dimuat
            applySidebarState();

            toggleBtn.addEventListener('click', () => {
                sidebarVisible = !sidebarVisible;
                applySidebarState();
            });

            overlay.addEventListener('click', () => {
                if (window.innerWidth < 640) {
                    sidebarVisible = false;
                    applySidebarState();
                }
            });

            window.addEventListener('resize', () => {
                applySidebarState(); // tidak memaksa buka, hanya menyesuaikan tampilan
            });

            // Dropdown sidebar
            window.toggleMenu = (menuId) => {
                const menu   = document.getElementById(menuId);
                const parent = menu.closest('.group');
                menu.classList.toggle('hidden');
                parent.classList.toggle('open');
            };

            // Highlight menu aktif
            window.setActive = (element) => {
                document.querySelectorAll('#sidebar a')
                        .forEach(a => a.classList.remove('bg-green-600', 'text-white'));
                element.classList.add('bg-green-600', 'text-white');
            };
        });
</script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('js')

</body>

</html>
