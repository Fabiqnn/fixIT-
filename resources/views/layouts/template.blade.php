<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'fixIT')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white h-screen ">
    <div class="flex h-full">
        @include('layouts.sidebar')
        <div id="overlay" class="fixed inset-0 opacity-50 hidden z-20 sm:hidden"></div>

        <div id="mainContent" class="flex-1 flex flex-col ml-64 transition-all duration-300 ">
            @include('layouts.header')
            <main class="h-screen ml-2 mt-2 mr-2 mb-2 border border-gray-300 p-6 rounded-lg shadow-md font-inter">
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        let sidebarVisible = true;
        const overlay = document.getElementById('overlay');


        function toggleSidebar(show) {
            const isMobile = window.innerWidth < 640;
            const isDesktop = window.innerWidth >= 640;

            sidebarVisible = show;

            if (show) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                if (isDesktop) {
                    mainContent.classList.add('ml-64');
                    mainContent.classList.remove('ml-0');
                } else {
                    mainContent.classList.add('ml-0');
                    mainContent.classList.remove('ml-64');
                    overlay.classList.remove('hidden');
                }
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-0');
                overlay.classList.add('hidden');
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth < 640) {
                toggleSidebar(false);
            }
        });

        toggleBtn.addEventListener('click', () => {
            toggleSidebar(!sidebarVisible);
        });

        overlay.addEventListener('click', () => {
            if (window.innerWidth < 640) {
                toggleSidebar(false);
            }
        });

        function setActive(element) {
            const menuItems = document.querySelectorAll('a');
            menuItems.forEach(item => item.classList.remove('bg-green-600', 'text-white'));
            element.classList.add('bg-green-600', 'text-white');
        }
    </script>
    @stack('js')
</body>

</html>
