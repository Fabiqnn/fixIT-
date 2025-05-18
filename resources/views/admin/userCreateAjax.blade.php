<form action="" method="POST" class="space-y-4 font-inter">
    @csrf
    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <div class="bg-green-700 text-white font-bold px-6 py-3 rounded-t-md mb-6">
            Tambah Pengguna
        </div>
        <div>
            <label class="block mb-1 font-semibold">Nama Lengkap</label>
            <input type="text" name="nama_lengkap"
                class="w-full border border-green-200 rounded p-2 outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Nama Lengkap">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-semibold">Level</label>
                <input type="text" name="level" class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="Level">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Keterangan Level</label>
                <input type="text" name="keterangan_level"
                    class="w-full border border-green-200 rounded p-2 outline-none" placeholder="Keterangan Level">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-semibold">Kelas</label>
                <input type="text" name="kelas" class="w-full border border-green-200 rounded p-2 outline-none"
                    placeholder="Kelas">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Tanggal Lahir</label>
                <input type="text" name="tanggal_lahir"
                    class="w-full border border-green-200 rounded p-2 outline-none" placeholder="Tanggal Lahir">
            </div>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Kontak</label>
            <input type="text" name="kontak" class="w-full border border-green-200 rounded p-2 outline-none"
                placeholder="Kontak">
        </div>
        <div>
            <label class="block mb-1 font-semibold">NIM</label>
            <input type="text" name="nim" class="w-full border border-green-200 rounded p-2 outline-none"
                placeholder="NIM">
        </div>
        <div class="flex justify-end mt-6">
            <button type="submit"
                class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition">Tambah</button>
        </div>
    </div>
</form>
