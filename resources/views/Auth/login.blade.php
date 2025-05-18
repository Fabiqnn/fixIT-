<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')

    <title>Login | fixIT!</title>
</head>
<body class="min-h-screen flex items-center justify-center bg-silver">
    <div class="flex w-full max-w-6xl shadow-md rounded-lg overflow-hidden">
        <div class="hidden md:block w-1/2 bg-[#f0f3f7]">
            <img src="{{ asset('assets/login1.png') }}" alt="Login Illustration" class="object-cover h-full w-full">
        </div>

        <div class="w-full md:w-1/2 bg-white pt-12 flex ">
            <div class="flex flex-col items-center space-y-6 w-full">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('assets/mechanic-hijau-tua.png') }}" alt="Logo" class="h-10">
                    <h1 class="text-3xl font-bold text-green-800 font-glacial">fixIT!</h1>
                </div>
                <div class="w-full h-full flex items-center p-13 ">
                    <form action="{{ url('login') }}" method="POST" class="w-full space-y-10 ">
                        @csrf
    
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-greenshade1 pointer-events-none">
                                <i class="fa-regular fa-user"></i>
                            </span>
                            <input type="text" name="noInduk" placeholder="No Induk"
                                class="w-full pl-10 pr-4 py-2 border-none ring-1 ring-greenPrimary rounded focus:outline-none focus:ring-greenshade1 placeholder:text-green-700 text-sm">
                        </div>
    
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-greenshade1 pointer-events-none">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="pass" id="pass" placeholder="Password"
                                class="w-full pl-10 pr-4 py-2 border-none ring-1 ring-greenPrimary rounded focus:outline-none focus:ring-greenshade1 placeholder:text-green-700 text-sm">
                            <span class="absolute inset-y-0 right-0 flex items-center justify-center pr-3 text-greenshade1 w-10" id="show">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
    
                        <button type="submit"
                            class="w-full bg-green-700 text-white py-2 rounded hover:bg-green-800 transition-colors duration-100">
                            Masuk
                        </button>
                    </form>
                </div>
                <div class="bg-silver p-3 w-full text-center">
                    <span class="text-blackshade1 text-sm">copyright ©</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            const password = document.getElementById('pass');
            const show = document.getElementById('show');
            let isOpen = false;

            show.addEventListener('click', function() {
                if (!isOpen) {
                    password.type = 'text';
                    show.querySelector('i').classList.remove('fa-eye')
                    show.querySelector('i').classList.add('fa-eye-slash')
                    isOpen = true;
                } else if (isOpen) {
                    password.type = 'password';
                    show.querySelector('i').classList.remove('fa-eye-slash')
                    show.querySelector('i').classList.add('fa-eye')
                    isOpen = false;
                }
            });
        });
    </script>
</body>

</html>