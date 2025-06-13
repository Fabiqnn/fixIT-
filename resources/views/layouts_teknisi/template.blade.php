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
        @include('layouts_teknisi.sidebar')
        <div id="overlay" class="fixed inset-0 opacity-50 hidden z-20 sm:hidden"></div>

            <div id="mainContent" class="flex flex-col flex-grow overflow-hidden sm:ml-64 transition-all duration-300">
            @include('layouts_teknisi.header')
            <main
                class="h-screen ml-2 mt-2 mr-2 mb-2 border border-gray-300 p-6 rounded-lg shadow-md font-inter overflow-auto">
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
        // Sidebar toggle
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        let sidebarVisible = true;

        function toggleSidebar(show) {
            const isMobile = window.innerWidth < 640;
            sidebarVisible = show;

            sidebar.classList.toggle('-translate-x-full', !show);
            sidebar.classList.toggle('translate-x-0', show);

            if (isMobile) {
                overlay.classList.toggle('hidden', !show);
            }
        }

        function setActive(element) {
            document.querySelectorAll('a').forEach(item =>
                item.classList.remove('bg-green-600', 'text-white')
            );
            element.classList.add('bg-green-600', 'text-white');
        }

        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            const parent = menu.closest('.group');
            menu.classList.toggle('hidden');
            parent.classList.toggle('open');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth < 640) toggleSidebar(false);
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 640 && !sidebarVisible) toggleSidebar(true);
        });

        toggleBtn?.addEventListener('click', () => toggleSidebar(!sidebarVisible));
        overlay?.addEventListener('click', () => {
            if (window.innerWidth < 640) toggleSidebar(false);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('js')

</body>

</html>
