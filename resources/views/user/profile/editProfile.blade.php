@php
    $isMahasiswa = $user->level_id == 1;
@endphp

<form action="{{ route('profile.update_ajax', $user->no_induk) }}" method="POST" id="form-edit"
    class="space-y-4 font-inter">
    @csrf
    @method('PUT')

    {{-- Added div for scrollability on small screens --}}
    <div class="overflow-y-auto h-full max-h-[80vh] md:max-h-full">
        <div class="space-y-6">
            <div class="p-6 space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold">No Induk</label>
                        <input type="text" name="no_induk" value="{{ $user->no_induk }}"
                            class="w-full border border-green-200 rounded p-2 outline-none" readonly>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Password <span class="text-sm text-gray-500">(Kosongkan jika
                                    tidak diubah)</span></label>
                        <input type="password" name="password"
                            class="w-full border border-green-200 rounded p-2 outline-none">
                        <span id="error-password" class="text-red-500 text-sm block mt-1"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}"
                            class="w-full border border-green-200 rounded p-2 outline-none" required>
                        <span id="error-nama_lengkap" class="text-red-500 text-sm block mt-1"></span>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Level</label>
                        <input type="text" name="level" value="{{ $user->level_id == 1 ? 'User' : ($user->level_id == 2 ? 'Admin' : ($user->level_id == 3 ? 'Teknisi' : 'Tidak diketahui')) }}"  class="w-full border border-green-200 rounded p-2 outline-none" readonly>
                        <span id="error-level_id" class="text-red-500 text-sm block mt-1"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="section-mahasiswa"
                    style="{{ $isMahasiswa ? '' : 'display: none;' }}">
                    <div>
                        <label class="block mb-1 font-semibold">Jurusan</label>
                        <select name="jurusan_id" class="w-full border border-green-200 rounded p-2 outline-none">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach ($jurusan as $j)
                                <option value="{{ $j->jurusan_id }}"
                                    {{ $user->jurusan_id == $j->jurusan_id ? 'selected' : '' }}>
                                    {{ $j->jurusan_nama }}
                                </option>
                            @endforeach
                        </select>
                        <span id="error-jurusan_id" class="text-red-500 text-sm block mt-1"></span>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Prodi</label>
                        <select name="prodi_id" class="w-full border border-green-200 rounded p-2 outline-none">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodi as $p)
                                <option value="{{ $p->prodi_id }}"
                                    {{ $user->prodi_id == $p->prodi_id ? 'selected' : '' }}>
                                    {{ $p->prodi_nama }}
                                </option>
                            @endforeach
                        </select>
                        <span id="error-prodi_id" class="text-red-500 text-sm block mt-1"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="w-full border border-green-200 rounded p-2 outline-none">
                        <span id="error-email" class="text-red-500 text-sm block mt-1"></span>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Nomor Telepon</label>
                        <input type="text" name="nomor_telp" value="{{ $user->nomor_telp }}"
                            class="w-full border border-green-200 rounded p-2 outline-none">
                        <span id="error-nomor_telp" class="text-red-500 text-sm block mt-1"></span>
                    </div>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Foto Profil</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full border border-green-200 rounded p-2 outline-none">
                    <span id="error-foto" class="text-red-500 text-sm block mt-1"></span>
                </div>
            </div>
        </div>
    </div> {{-- End of the new div --}}

    <div class="flex justify-end mt-6">
        <button type="submit"
            class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">
            Simpan Perubahan
        </button>
    </div>
</form>

<script>
    function initEditValidasi() {
        const MAHASISWA_LEVEL_ID = 1;

        $('#level_id').on('change', function() {
            const isMahasiswa = parseInt($(this).val()) === MAHASISWA_LEVEL_ID;
            if (isMahasiswa) {
                $('#section-mahasiswa').slideDown();
                $("select[name='jurusan_id'], select[name='prodi_id']").prop('required', true);
            } else {
                $('#section-mahasiswa').slideUp();
                $("select[name='jurusan_id'], select[name='prodi_id']").prop('required', false);
                $("select[name='jurusan_id'], select[name='prodi_id']").val('');
            }
        });

        if (typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate belum ter-load!");
            return;
        }

        $("#form-edit").validate({
            rules: {
                nama_lengkap: {
                    required: true,
                    maxlength: 100
                },
                level_id: { // Assuming level_id is handled via JavaScript for Mahasiswa section
                    // This rule might not be needed if level input is readonly
                },
                jurusan_id: {
                    required: "#section-mahasiswa:visible" // Only required if section-mahasiswa is visible
                },
                prodi_id: {
                    required: "#section-mahasiswa:visible" // Only required if section-mahasiswa is visible
                },
                email: {
                    required: true,
                    email: true
                },
                nomor_telp: {
                    required: true,
                    maxlength: 15
                }
            },
            messages: { // Adding messages for clarity
                nama_lengkap: {
                    required: "Nama lengkap wajib diisi.",
                    maxlength: "Nama lengkap tidak boleh lebih dari 100 karakter."
                },
                jurusan_id: {
                    required: "Jurusan wajib dipilih untuk mahasiswa."
                },
                prodi_id: {
                    required: "Prodi wajib dipilih untuk mahasiswa."
                },
                email: {
                    required: "Email wajib diisi.",
                    email: "Format email tidak valid."
                },
                nomor_telp: {
                    required: "Nomor telepon wajib diisi.",
                    maxlength: "Nomor telepon tidak boleh lebih dari 15 karakter."
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        if (response.status) {
                            closeModal(); // Make sure closeModal() is defined or remove if not needed

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: true,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            // Clear previous errors
                            $('.text-red-500').text('');
                            $.each(response.msgField, function(field, messages) {
                                $('#error-' + field).text(messages[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },

                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menyimpan data.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                // Place error message directly under the input field
                $('#error-' + element.attr('name')).text(error.text());
            },
            highlight: function(element) {
                $(element).addClass('border-red-500').removeClass('border-green-200'); // Add red border on error
            },
            unhighlight: function(element) {
                $(element).removeClass('border-red-500').addClass('border-green-200'); // Revert border on valid
                $('#error-' + $(element).attr('name')).text(''); // Clear error text
            }
        });
    }
</script>