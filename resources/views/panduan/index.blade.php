@extends('layouts_user.template') {{-- Asumsikan Anda punya layout utama --}}

@section('content')
    {{-- Tambahkan Alpine.js jika belum --}}
    @push('scripts')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Panduan Penggunaan <span class="text-blue-600">fixIT!</span></h1>

        <div class="prose max-w-none text-gray-700">
            <p>
                Selamat datang di halaman panduan **fixIT!** Di sini Anda akan menemukan informasi tentang bagaimana cara menggunakan platform ini untuk melaporkan masalah dan mengelola fasilitas kampus.
            </p>

            <h2 class="text-2xl font-semibold mt-10 mb-4">1. Cara Melaporkan Masalah</h2>
            <p>Untuk melaporkan masalah, ikuti langkah-langkah berikut:</p>
            <ol class="list-decimal list-inside pl-4">
                <li>Masuk ke akun Anda.</li>
                <li>Klik tombol **"Lapor Mudah"** atau navigasi ke halaman laporan.</li>
                <li>Isi formulir laporan dengan detail masalah yang Anda temui.</li>
                <li>Pilih kategori masalah yang sesuai (misalnya, listrik, air, kerusakan gedung).</li>
                <li>Unggah foto jika diperlukan untuk memberikan konteks lebih lanjut.</li>
                <li>Klik **"Kirim Laporan"**.</li>
            </ol>
            <p>Setelah laporan terkirim, tim kami akan segera menindaklanjuti.</p>

            <h2 class="text-2xl font-semibold mt-10 mb-4">2. Status Laporan</h2>
            <p>Anda dapat memantau status laporan Anda di halaman **"Laporan Saya"**. Status laporan akan berubah dari *`"Menunggu"`*, *`"Diproses"`*, hingga *`"Selesai"`*.</p>

            <h2 class="text-2xl font-semibold mt-10 mb-4">3. FAQ (Pertanyaan yang Sering Diajukan)</h2>
            <div class="space-y-4">
                <div x-data="{ open: false }" class="border rounded-lg p-4 bg-white shadow-sm">
                    <button @click="open = !open" class="flex justify-between items-center w-full text-left font-medium text-gray-800">
                        <span>Q: Berapa lama waktu yang dibutuhkan untuk menyelesaikan laporan?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="mt-2 text-gray-600">
                        A: Waktu penyelesaian tergantung pada kompleksitas masalah. Tim kami akan berusaha menyelesaikannya secepat mungkin.
                    </div>
                </div>

                <div x-data="{ open: false }" class="border rounded-lg p-4 bg-white shadow-sm">
                    <button @click="open = !open" class="flex justify-between items-center w-full text-left font-medium text-gray-800">
                        <span>Q: Bisakah saya mengedit laporan setelah dikirim?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="mt-2 text-gray-600">
                        A: Setelah laporan dikirim, Anda tidak bisa mengeditnya. Jika ada perubahan, silakan buat laporan baru atau hubungi administrator.
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-semibold mt-10 mb-4">4. Kontak Bantuan</h2>
            <p>
                Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi kami melalui halaman
                <a href="{{ url('/contact') }}" class="text-blue-600 hover:underline">Kontak</a>.
            </p>
        </div>
    </div>
@endsection