@extends('layouts_teknisi.template')
@section('title', 'Profil Saya')
@section('header', 'Profil Pengguna')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 sm:p-8 font-inter">
        {{-- Menggunakan flexbox untuk pengaturan tata letak responsif --}}
        <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-center md:items-start">

            {{-- Bagian Foto Profil (akan di atas di mobile, di kanan di desktop) --}}
            <div class="w-48 h-48 sm:w-60 sm:h-60 relative flex-shrink-0 order-1 md:order-2"> {{-- order-1 di mobile, order-2 di desktop --}}
                <div class="flex justify-center"> {{-- Pusatkan gambar di dalam div-nya --}}
                    @if ($user->foto)
                        <img src="{{ asset('uploads/foto/' . $user->foto) }}" alt="Foto Profil"
                            class="w-full h-full object-cover rounded-full shadow border">
                    @else
                        <img src="{{ asset('uploads/foto/default-avatar.jpg') }}" alt="Default Avatar"
                            class="w-full h-full object-cover rounded-full shadow border">
                    @endif
                </div>
            </div>

            {{-- Bagian Informasi Pengguna (akan di bawah di mobile, di kiri di desktop) --}}
            <div class="space-y-4 sm:space-y-6 flex-grow order-2 md:order-1 w-full"> {{-- order-2 di mobile, order-1 di desktop --}}
                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">Nama Lengkap</label>
                    <p class="text-base sm:text-lg font-medium border-b border-gray-300 pb-1">{{ $user->nama_lengkap }}</p>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">No Induk</label>
                    <p class="text-base sm:text-lg font-medium border-b border-gray-300 pb-1">{{ $user->no_induk }}</p>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">Role</label>
                    <p class="text-base sm:text-lg font-medium border-b border-gray-300 pb-1">{{ $user->level->level_nama }}</p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">E-Mail</label>
                    <p class="text-sm sm:text-base border-b border-gray-300 pb-1">{{ $user->email ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">Phone</label>
                    <p class="text-sm sm:text-base border-b border-gray-300 pb-1">{{ $user->nomor_telp ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Tombol Edit Profile selalu di bawah --}}
        <div class="text-center mt-6">
            <button class="button1 px-6 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                onclick="modalAction('{{ url('/admin/profile/' . $user->no_induk . '/edit') }}')">
                Edit Profile
            </button>
        </div>
    </div>

    <div id="modalContainer" class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-sm hidden p-4">
        <div class="bg-white rounded shadow-lg max-w-lg md:max-w-4xl w-full relative transform transition-all duration-300 ease-out scale-95 opacity-0" id="modal-box">
            <button onclick="closeModal()"
                class="absolute top-3 right-3 text-gray-700 hover:text-gray-900 text-3xl font-bold cursor-pointer leading-none">
                &times;
            </button>
            <div id="modalContent" class="w-full p-6"></div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        function modalAction(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('modalContent').innerHTML = html;
                    const modalContainer = document.getElementById('modalContainer');
                    const modalBox = document.getElementById('modal-box');

                    modalContainer.classList.remove('hidden');
                    modalContainer.classList.add('flex');

                    // Trigger reflow to apply transition
                    void modalBox.offsetWidth;

                    modalBox.classList.add('scale-100', 'opacity-100');
                    modalBox.classList.remove('scale-95', 'opacity-0');


                    // Re-evaluate scripts inside the fetched content
                    $('#modalContent script').each(function() {
                        $.globalEval(this.text || this.textContent || this.innerHTML || '');
                    });
                    if (typeof initEditValidasi === "function") {
                        initEditValidasi();
                    }
                })
                .catch(error => {
                    console.error('Error fetching modal:', error);
                });
        }

        function closeModal() {
            const modalContainer = document.getElementById('modalContainer');
            const modalBox = document.getElementById('modal-box');

            modalBox.classList.remove('scale-100', 'opacity-100');
            modalBox.classList.add('scale-95', 'opacity-0');

            modalBox.addEventListener('transitionend', function handler() {
                modalContainer.classList.remove('flex');
                modalContainer.classList.add('hidden');
                document.getElementById('modalContent').innerHTML = '';
                modalBox.removeEventListener('transitionend', handler);
            });
        }
    </script>
@endpush