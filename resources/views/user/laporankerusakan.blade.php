@extends('layouts_user.template')

@section('content')
<div class="bg-green-700 text-white text-lg font-bold p-4 rounded-br-2xl">
    Laporan Kerusakan
</div>
@if ($errors->any())
    <div class="bg-red-200 text-red-800 p-3 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if ($errors->has('deskripsi'))
    <p class="text-red-600 text-sm mt-1">{{ $errors->first('deskripsi') }}</p>
@endif

<form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<!-- Semua inputan dropdown dan upload tadi -->

<div class="p-8">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Upload Foto -->
        <div x-data="{ imageUrl: null }" x-init="
            $refs.dropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                $refs.dropArea.classList.add('border-green-500', 'text-green-500');
                $refs.dropText.textContent = 'Drop the file here';
            });
            $refs.dropArea.addEventListener('dragleave', () => {
                $refs.dropArea.classList.remove('border-green-500', 'text-green-500');
                $refs.dropText.textContent = 'Drag and drop or click here to select file';
            });
            $refs.dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    imageUrl = URL.createObjectURL(file);
                    $refs.upload.files = e.dataTransfer.files;
                    $refs.dropText.textContent = 'File selected: ' + file.name;
                } else {
                    imageUrl = null;
                    $refs.dropText.textContent = 'File bukan gambar yang valid.';
                }
            });
        ">
            <h2 class="text-indigo-700 font-semibold mb-2">Upload Foto</h2>
            <label x-ref="dropArea"
                   class="cursor-pointer border-2 border-dashed border-gray-300 rounded-lg h-40 flex items-center justify-center text-gray-400 text-sm hover:border-green-500 hover:text-green-500 transition relative">
                <span x-ref="dropText" class="z-10">Drag and drop or click here to select file</span>
                <input x-ref="upload" name="foto" type="file" class="hidden" accept="image/*"
                       @change="
                            const file = $event.target.files[0];
                            if (file && file.type.startsWith('image/')) {
                                imageUrl = URL.createObjectURL(file);
                                $refs.dropText.textContent = 'File selected: ' + file.name;
                            } else {
                                imageUrl = null;
                                $refs.dropText.textContent = 'Drag and drop or click here to select file';
                            }
                       ">
                <template x-if="imageUrl">
                    <img :src="imageUrl" alt="Preview" class="absolute inset-0 object-contain max-h-full max-w-full p-2 rounded" />
                </template>
            </label>
        </div>

        <!-- Form Interaktif -->
        <div x-data="dropdownForm()" x-init="init()" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                <!-- GEDUNG -->
                <div class="relative" x-data="{ open: false }">
                    <label class="text-indigo-700 font-semibold mb-1">Gedung</label>
                    <button type="button" @click="open = !open"
                            class="w-full border border-gray-300 rounded-md p-2 flex justify-between items-center focus:ring-2 focus:ring-green-500">
                        <span x-text="selectedGedungText || 'Pilih Gedung'"></span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border rounded-md shadow max-h-60 overflow-auto">
                        @foreach ($gedung as $g)
                        <li @click="gedung_id = '{{ $g->gedung_id }}'; selectedGedungText = '{{ $g->gedung_nama }}'; loadLantai(); open = false"
                            class="px-4 py-2 hover:bg-green-100 cursor-pointer">{{ $g->gedung_nama }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- LANTAI -->
                <div class="relative" x-data="{ open: false }">
                    <label class="text-indigo-700 font-semibold mb-1">Lantai</label>
                    <button type="button" @click="open = !open" :disabled="lantaiList.length === 0"
                            class="w-full border border-gray-300 rounded-md p-2 flex justify-between items-center focus:ring-2 focus:ring-green-500">
                        <span x-text="selectedLantaiText || 'Pilih Lantai'"></span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border rounded-md shadow max-h-60 overflow-auto">
                        <template x-for="lantai in lantaiList" :key="lantai.id_lantai">
                            <li @click="lantai_id = lantai.id_lantai; selectedLantaiText = lantai.nama_lantai; loadRuangan(); open = false"
                                class="px-4 py-2 hover:bg-green-100 cursor-pointer" x-text="lantai.nama_lantai"></li>
                        </template>
                    </ul>
                </div>

                <!-- RUANGAN -->
                <div class="relative" x-data="{ open: false }">
                    <label class="text-indigo-700 font-semibold mb-1">Ruangan</label>
                    <button type="button" @click="open = !open" :disabled="ruanganList.length === 0"
                            class="w-full border border-gray-300 rounded-md p-2 flex justify-between items-center focus:ring-2 focus:ring-green-500">
                        <span x-text="selectedRuanganText || 'Pilih Ruangan'"></span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border rounded-md shadow max-h-60 overflow-auto">
                        <template x-for="r in ruanganList" :key="r.id_ruangan">
                            <li @click="ruangan_id = r.id_ruangan; selectedRuanganText = r.keterangan; loadFasilitas(); open = false"
                                class="px-4 py-2 hover:bg-green-100 cursor-pointer" x-text="r.keterangan"></li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Fasilitas -->
            <div class="relative" x-data="{ open: false }">
                <label class="text-indigo-700 font-semibold mb-1">Fasilitas</label>
                <button type="button" @click="open = !open" :disabled="fasilitasList.length === 0"
                        class="w-full border border-gray-300 rounded-md p-2 flex justify-between items-center focus:ring-2 focus:ring-green-500">
                    <span x-text="selectedFasilitasText || 'Pilih Fasilitas'"></span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border rounded-md shadow max-h-60 overflow-auto">
                    <template x-for="f in fasilitasList" :key="f.fasilitas_id">
                        <li @click="fasilitas_id = f.fasilitas_id; selectedFasilitasText = f.nama_fasilitas; open = false"
                            class="px-4 py-2 hover:bg-green-100 cursor-pointer" x-text="f.nama_fasilitas"></li>
                    </template>
                </ul>
                <input type="hidden" name="fasilitas_id" :value="fasilitas_id">
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    <div x-data="{ deskripsi: '' }" class="mt-8">
    <h2 class="text-indigo-700 font-semibold mb-2">Deskripsi Kerusakan</h2>
    <textarea
        name="deskripsi"
        rows="5"
        maxlength="2000"
        x-model="deskripsi"
        class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-green-500"
        placeholder="Tuliskan deskripsi kerusakan...">
    </textarea>
    <div class="text-right text-sm text-gray-400 mt-1" x-text="deskripsi.length + '/2000'">0/2000</div>
</div>

    <!-- Tombol Kirim -->
    <div class="mt-8 flex justify-end">
        <button class="bg-green-700 text-white px-6 py-2 rounded-md hover:bg-green-800 transition" type="submit">Kirim</button>
    </div>
</div>
</form>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script>
function dropdownForm() {
    return {
        gedung_id: '',
        lantai_id: '',
        ruangan_id: '',
        fasilitas_id: '',

        selectedGedungText: '',
        selectedLantaiText: '',
        selectedRuanganText: '',
        selectedFasilitasText: '',

        lantaiList: [],
        ruanganList: [],
        fasilitasList: [],

        async loadLantai() {
            this.lantai_id = '';
            this.selectedLantaiText = '';
            const res = await fetch(`/ajax/lantai?gedung_id=${this.gedung_id}`);
            this.lantaiList = await res.json();
            this.ruanganList = [];
            this.fasilitasList = [];
        },

        async loadRuangan() {
            this.ruangan_id = '';
            this.selectedRuanganText = '';
            const res = await fetch(`/ajax/ruangan?gedung_id=${this.gedung_id}&lantai_id=${this.lantai_id}`);
            this.ruanganList = await res.json();
            this.fasilitasList = [];
        },

        async loadFasilitas() {
            this.fasilitas_id = '';
            this.selectedFasilitasText = '';
            const res = await fetch(`/ajax/fasilitas?ruangan_id=${this.ruangan_id}`);
            this.fasilitasList = await res.json();
        },

        init() {
             @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
        }
    }
}
</script>
@endpush
