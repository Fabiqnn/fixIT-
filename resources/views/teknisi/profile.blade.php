@extends('layouts_teknisi.template')
@section('title', 'Profil Saya')
@section('header', 'Profil Pengguna')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-8 font-inter">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="space-y-6">
                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">Nama Lengkap</label>
                    <p class="text-lg font-medium border-b border-gray-300 pb-1">{{ $user->nama_lengkap }}</p>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">No Induk</label>
                    <p class="text-lg font-medium border-b border-gray-300 pb-1">{{ $user->no_induk }}</p>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">Role</label>
                    <p class="text-lg font-medium border-b border-gray-300 pb-1">{{ $user->level->level_nama }}</p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">E-Mail</label>
                    <p class="text-base border-b border-gray-300 pb-1">{{ $user->email ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wide text-gray-500 block mb-1">Phone</label>
                    <p class="border-b border-gray-300 pb-1">{{ $user->nomor_telp ?? '-' }}</p>
                </div>
            </div>

            <div class="flex justify-center my-auto">
                <div class="w-70 h-70 relative">
                    @if ($user->foto)
                        <img src="{{ asset('uploads/foto/' . $user->foto) }}" alt="Foto Profil"
                            class="w-full h-full object-cover rounded-full shadow border">
                    @else
                        <img src="{{ asset('uploads/foto/default-avatar.jpg') }}" alt="Default Avatar"
                            class="w-full h-full object-cover rounded-full shadow border">
                    @endif
                </div>
            </div>
            <button class="button1" onclick="modalAction('{{ url('/admin/profile/' . $user->no_induk . '/edit') }}')">
                Edit Profile
            </button>
        </div>
    </div>

    <div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded shadow-lg max-w-4xl w-full relative" id="modal-box">
            <button onclick="closeModal()"
                class="absolute top-4.5 right-6 text-white hover:text-gray-700 text-2xl font-bold cursor-pointer">
                &times;
            </button>
            <div id="modalContent" class="w-full"></div>
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
                    document.getElementById('modalContainer').classList.remove('hidden');
                    document.getElementById('modalContainer').classList.add('flex');
                    document.getElementById('modalContainer').classList.add('autoAppear');
                    document.getElementById('modal-box').classList.add('autoShow3');

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
            document.getElementById('modalContainer').classList.remove('flex');
            document.getElementById('modalContainer').classList.add('hidden');
            document.getElementById('modalContent').innerHTML = '';
        }
    </script>
@endpush
