@extends('layouts_user.template')

@section('title', 'Profile')

@section('content')
<div class="max-w-5xl mx-auto mb-10 mt-10 bg-white shadow-md rounded-lg overflow-hidden min-h-[600px]">

    <!-- Header / Cover -->
    <div class="relative bg-green-700 h-40 flex items-center justify-center">
        <!-- Dekorasi Lingkaran -->
        <div class="absolute right-10 bottom-4 w-32 h-32 rounded-full border-4 border-yellow-400"></div>
        <div class="absolute right-24 bottom-8 w-24 h-24 rounded-full border-4 border-rose-400"></div>

        <!-- Foto Profil -->
        <div class="absolute -bottom-12 left-10">
            <div class="w-24 h-24 rounded-full bg-gray-300 border-4 border-white"></div>
        </div>
    </div>

    <!-- Body Konten -->
    <div class="pt-16 px-10 pb-10">
        <!-- Nama dan Jabatan -->
        <div class="mb-6 flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $user->nama_lengkap }}</h1>
                <p class="text-gray-500">{{ $user->level->level_nama }}</p>
            </div>
            <button onclick="modalAction('{{ route('profile.edit_ajax', $user->no_induk) }}')"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                <i class="fas fa-edit mr-2"></i> Edit Profil
            </button>
        </div>

        <!-- Info Kontak -->
        <div class="flex flex-wrap gap-6 text-sm text-gray-800">
            <div class="flex items-center gap-2">
                <span class="text-orange-500"><i class="fas fa-graduation-cap"></i></span>
                <span>{{ $user->prodi->prodi_nama ?? '-' }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-orange-500"><i class="fas fa-phone"></i></span>
                <span>{{ $user->nomor_telp ?? '-' }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-orange-500"><i class="fas fa-envelope"></i></span>
                <span>{{ $user->email ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<div id="ajaxModal" 
    class="fixed inset-0 bg-transparent flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-xl shadow-lg max-w-3xl w-full mx-4 p-6 relative">
    <button onclick="closeModal()" 
      class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
    <h5 class="text-xl font-bold mb-4">Edit Data User</h5>
    <div id="modalContent">
      <!-- Konten AJAX akan dimuat di sini -->
    </div>
  </div>
</div>

<script>
function modalAction(url) {
    $.get(url, function(res) {
        $('#modalContent').html(res);
        $('#ajaxModal').removeClass('hidden');
        if (typeof initEditValidasi === 'function') {
            initEditValidasi();
        }
    }).fail(function() {
        alert("Gagal memuat konten.");
    });
}

function closeModal() {
    $('#ajaxModal').addClass('hidden');
}

// Tutup modal kalau klik background overlay
$('#ajaxModal').on('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush
