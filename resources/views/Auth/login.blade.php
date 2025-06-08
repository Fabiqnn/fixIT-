<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | fixIT!</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css') </head>

<body class="min-h-screen flex items-center justify-center bg-silver p-4">
    <div class="flex flex-col md:flex-row w-full max-w-6xl shadow-md rounded-lg overflow-hidden">
        <div class="w-full md:w-1/2 bg-[#f0f3f7] hidden md:block"> 
            <img src="{{ asset('assets/login1.png') }}" alt="Login Illustration" class="object-cover h-48 md:h-full w-full">
        </div>

        <div class="w-full md:w-1/2 bg-white pt-12 flex flex-col items-center justify-between">
            <div class="flex flex-col items-center space-y-6 w-full">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('assets/mechanic-hijau-tua.png') }}" alt="Logo" class="h-10">
                    <h1 class="text-3xl font-bold text-green-800">fixIT!</h1>
                </div>

                <div class="w-full h-full flex items-center p-10">
                    <form id="form-login" action="{{ url('login') }}" method="POST" class="w-full space-y-6">
                        @csrf

                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-700 pointer-events-none">
                                <i class="fa-regular fa-user"></i>
                            </span>
                            <input type="text" name="noInduk" id="noInduk" placeholder="Masukkan Nomor Induk"
                                class="pl-10 w-full py-2 ring-1 ring-greenPrimary rounded focus:outline-none focus:ring-green-700 text-sm placeholder:text-green-700" />
                        </div>
                        <small id="error-noInduk" class="text-red-500 text-sm mt-1 block"></small>


                        <div class="mb-4">
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-green-700 pointer-events-none">
                                    <i class="fa-solid fa-lock"></i>
                                </span>

                                <input type="password" name="pass" id="pass" placeholder="Password"
                                    class="w-full pl-10 pr-12 py-2 border-none ring-1 ring-greenPrimary rounded focus:outline-none focus:ring-green-700 text-sm placeholder:text-green-700">

                                <span
                                    class="absolute inset-y-0 right-0 flex items-center justify-center pr-3 text-green-700 w-10 cursor-pointer"
                                    id="show">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>

                            <small id="error-general" class="text-red-500 text-sm text-center block"></small>
                        </div>

                        <button type="submit"
                            class="w-full bg-green-700 text-white py-2 rounded hover:bg-green-800 transition">
                            Masuk
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-silver p-3 w-full text-center">
                <span class="text-black text-sm">&copy; fixIT! {{ now()->year }}</span>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        $('#show').on('click', function() {
            const pass = $('#pass');
            const icon = $(this).find('i');
            const isPassword = pass.attr('type') === 'password';
            pass.attr('type', isPassword ? 'text' : 'password');
            icon.toggleClass('fa-eye fa-eye-slash');
        });

        // AJAX login handling
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form-login').on('submit', function(e) {
            e.preventDefault();
            $('.text-red-500').text(''); // clear all previous errors

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        $.each(response.msgField, function(field, message) {
                            $('#error-' + field).text(message[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Gagal',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Server',
                        text: 'Terjadi kesalahan saat menghubungi server.'
                    });
                }
            });
        });

        if (response.status === false) {
            if (response.msgField) {
                $.each(response.msgField, function(field, message) {
                    $('#error-' + field).text(message[0]);
                });
            }
            if (response.message) {
                $('#error-general').text(response.message);
            }
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: response.message
            });
        }
     
    </script>
</body>

</html>