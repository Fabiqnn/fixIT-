@extends('layouts_user.template')

@section('content')
    {{-- Alpine.js untuk interaktivitas --}}
    @push('scripts')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush

    <div class="container px-4 py-10 animate-fade-in w-full max-w-[1400px] mx-auto">
        <h1 class="text-4xl font-bold mb-8 text-gray-800 flex items-center gap-2">
            Panduan Penggunaan <span class="text-green-600">fixIT!</span>
        </h1>

        <div class="prose max-w-none text-gray-700 space-y-10">
            <section>
                <h2 class="text-2xl font-semibold mb-3 text-black-700">📌 1. Cara Melaporkan Masalah</h2>
                <p>Ikuti langkah-langkah berikut untuk melaporkan masalah:</p><br>
                <ul class="list-inside space-y-2">
                    <li>✅ Masuk ke akun Anda.</li>
                    <li>✅ Klik tombol <strong>"Lapor Mudah"</strong> atau navigasi ke halaman laporan.</li>
                    <li>✅ Isi formulir laporan dengan detail masalah yang Anda temui.</li>
                    <li>✅ Pilih kategori masalah (misal: listrik, air, kerusakan gedung).</li>
                    <li>✅ Unggah foto jika diperlukan.</li>
                    <li>✅ Klik <strong>"Kirim Laporan"</strong>.</li>
                </ul>
                <p class="mt-2 text-green-700">📥 Laporan akan langsung diproses oleh tim kami.</p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold mb-3 text-black-700">📊 2. Status Laporan</h2>
                <p>
                    Pantau status laporan di halaman <strong>"Laporan Saya"</strong>. Status laporan:
                    <span class="inline-block bg-yellow-100 text-yellow-800 px-2 rounded mx-1">Menunggu</span>,
                    <span class="inline-block bg-blue-100 text-blue-800 px-2 rounded mx-1">Diproses</span>,
                    <span class="inline-block bg-green-100 text-green-800 px-2 rounded mx-1">Selesai</span>.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold mb-3 text-black-700">❓ 3. FAQ (Pertanyaan yang Sering Diajukan)</h2>
                <div class="space-y-4">
                    @foreach([
                        [
                            'q' => 'Berapa lama waktu yang dibutuhkan untuk menyelesaikan laporan?',
                            'a' => 'Waktu penyelesaian tergantung pada kompleksitas masalah. Tim kami akan berusaha menyelesaikannya secepat mungkin.',
                        ],
                        [
                            'q' => 'Bisakah saya mengedit laporan setelah dikirim?',
                            'a' => 'Setelah laporan dikirim, Anda tidak bisa mengeditnya. Jika ada perubahan, silakan buat laporan baru atau hubungi administrator.',
                        ]
                    ] as $faq)
                        <div x-data="{ open: false }" class="border rounded-lg p-4 bg-gray-50 shadow-sm transition hover:shadow-md">
                            <button @click="open = !open" class="flex justify-between items-center w-full text-left font-medium text-gray-800">
                                <span>{{ $faq['q'] }}</span>
                                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="mt-2 text-gray-600">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-semibold mb-3 text-black-700">📞 4. Kontak Bantuan</h2>
                <p>
                    Masih bingung atau butuh bantuan? Kunjungi halaman 
                    <a href="{{ url('/contact') }}" class="text-blue-600 hover:underline">Kontak</a> dan tim kami siap membantu!
                </p>
            </section>
        </div>
    </div>

    {{-- Animasi masuk --}}
    <style>
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection
