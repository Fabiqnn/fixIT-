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