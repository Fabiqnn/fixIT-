@extends('layouts_user.template')


@section('content')
<div class="bg-green-700 text-white text-lg font-bold p-4 rounded-br-2xl">
    Laporan Kerusakan
  </div>

  <div class="p-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Upload Foto -->
<div>
    <h2 class="text-indigo-700 font-semibold mb-2">Upload Foto</h2>
    <label for="upload"
           id="drop-area"
           class="cursor-pointer border-2 border-dashed border-gray-300 rounded-lg h-40 flex items-center justify-center text-gray-400 text-sm hover:border-green-500 hover:text-green-500 transition">
        <span id="drop-text">Drag and drop or click here to select file</span>
        <input id="upload" name="foto" type="file" class="hidden" accept="image/*" />
    </label>
</div>


      <!-- Form Inputs -->
      <div class="space-y-4">
        <div>
          <h2 class="text-indigo-700 font-semibold mb-1">Fasilitas</h2>
          <input type="text" placeholder="AC" class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500" />
        </div>
        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block font-semibold mb-1">Gedung</label>
            <input type="text" placeholder="JTI" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
          </div>
          <div>
            <label class="block font-semibold mb-1">Ruangan</label>
            <input type="text" placeholder="LPR 3" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
          </div>
          <div>
            <label class="block font-semibold mb-1">Lantai</label>
            <input type="text" placeholder="7" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
          </div>
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
<script>
  const dropArea = document.getElementById('drop-area');
  const fileInput = document.getElementById('upload');
  const dropText = document.getElementById('drop-text');


  dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('border-green-500', 'text-green-500');
    dropText.textContent = 'Drop the file here';
  });


  dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('border-green-500', 'text-green-500');
    dropText.textContent = 'Drag and drop or click here to select file';
  });


  dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.classList.remove('border-green-500', 'text-green-500');
    dropText.textContent = 'File selected: ' + e.dataTransfer.files[0].name;


    fileInput.files = e.dataTransfer.files;
  });
</script>
@endpush