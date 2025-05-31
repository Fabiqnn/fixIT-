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