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