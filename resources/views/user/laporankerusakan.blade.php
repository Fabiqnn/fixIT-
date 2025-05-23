@extends('layouts_user.template')

@section('content')
<div class="bg-green-700 text-white text-lg font-bold p-4 rounded-br-2xl">
    Laporan Kerusakan
</div>

<div class="p-8">
    <!-- Grid untuk Upload + Form Input -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Upload Foto -->
        <div x-data="{ imageUrl: null }" 
             x-init="
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
                    $refs.dropArea.classList.remove('border-green-500', 'text-green-500');
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
            <label id="drop-area" x-ref="dropArea"
                   class="cursor-pointer border-2 border-dashed border-gray-300 rounded-lg h-40 flex items-center justify-center text-gray-400 text-sm hover:border-green-500 hover:text-green-500 transition relative ">
                <span id="drop-text" x-ref="dropText" class="z-10">Drag and drop or click here to select file</span>
                <input id="upload" x-ref="upload" name="foto" type="file" class="hidden" accept="image/*"
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

        <!-- Form Inputs -->
        <div class="space-y-4">
            <!-- Fasilitas -->
        <div x-data="{ open: false, selected: 'Pilih Fasilitas' }" class="relative">
            <h2 class="text-indigo-700 font-semibold mb-1">Fasilitas</h2>
            <button @click="open = !open"
                class="w-full bg-white border border-gray-300 rounded-md p-2 flex justify-between items-center focus:ring-2 focus:ring-green-500">
                <span x-text="selected"></span>
                <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <ul x-show="open" @click.away="open = false"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                @foreach ($fasilitas as $item)
                <li @click="selected = '{{ $item->nama_fasilitas }}'; open = false"
                        class="px-4 py-2 text-gray-800 hover:bg-green-100 cursor-pointer">
                {{ $item->nama_fasilitas }}
            </li>
                @endforeach
            </ul>
        </div>


            <!-- Gedung, Ruangan, Lantai -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach (['Gedung' => ['JTI', 'FT', 'FMIPA'], 'Ruangan' => ['LPR 1', 'LPR 2', 'LPR 3'], 'Lantai' => ['1','2','3','4','5']] as $label => $options)
                <div x-data="{ open: false, selected: 'Pilih {{ $label }}' }" class="relative">
                    <label class="text-indigo-700 font-semibold mb-1">{{ $label }}</label>
                    <button @click="open = !open"
                            class="w-full bg-white border border-gray-300 rounded-md p-2 flex justify-between items-center focus:ring-2 focus:ring-green-500">
                        <span x-text="selected"></span>
                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <ul x-show="open" @click.away="open = false"
                        class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                        @foreach ($options as $opt)
                        <li @click="selected = '{{ $opt }}'; open = false" class="px-4 py-2 hover:bg-green-100 cursor-pointer">{{ $opt }}</li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    <div class="mt-8">
        <h2 class="text-indigo-700 font-semibold mb-2">Deskripsi Kerusakan</h2>
        <textarea rows="5" maxlength="2000"
                  class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                  placeholder="Tuliskan deskripsi kerusakan..."></textarea>
        <div class="text-right text-sm text-gray-400 mt-1">0/2000</div>
    </div>

    <!-- Tombol Kirim -->
    <div class="mt-8 flex justify-end">
        <button class="bg-green-700 text-white px-6 py-2 rounded-md hover:bg-green-800 transition">Kirim</button>
    </div>
</div>
@endsection

@push('js')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
