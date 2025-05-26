<form action="{{ url('/admin/user/update_ajax/' . $user->user_id) }}" method="POST" id="form-edit"
    class="space-y-4 font-inter">
    @csrf
    @method('PUT')
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Edit Data User
        </div>
        <div class="p-6 space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Username</label>
                    <input type="text" name="username" value="{{ $user->username }}"
                        class="w-full border border-green-300 rounded p-2 outline-none" required>
                    <span id="error-username" class="text-red-500 text-sm block mt-1"></span>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Password <span
                            class="text-sm text-gray-500">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password"
                        class="w-full border border-green-300 rounded p-2 outline-none">
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
                    <select name="level_id" class="w-full border border-green-200 rounded p-2 outline-none" required>
                        <option value="">-- Pilih Level --</option>
                        @foreach ($level as $l)
                            <option value="{{ $l->level_id }}" {{ $user->level_id == $l->level_id ? 'selected' : '' }}>
                                {{ $l->level_nama }}
                            </option>
                        @endforeach
                    </select>
                    <span id="error-level_id" class="text-red-500 text-sm block mt-1"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold">Jurusan</label>
                    <select name="jurusan_id" class="w-full border border-green-200 rounded p-2 outline-none" required>
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
                    <select name="prodi_id" class="w-full border border-green-200 rounded p-2 outline-none" required>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold">NIP</label>
                    <input type="text" name="nip" value="{{ $user->nip }}"
                        class="w-full border border-green-200 rounded p-2 outline-none">
                </div>
                <div>
                    <label class="block mb-1 font-semibold">NIM</label>
                    <input type="text" name="nim" value="{{ $user->nim }}"
                        class="w-full border border-green-200 rounded p-2 outline-none">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    function initEditValidasi() {
        console.log('Validasi Edit User');

        if (typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate belum ter-load!");
            return;
        }

        const form = $("#form-edit");
        if (form.length === 0) {
            console.error("Form #form-edit tidak ditemukan di DOM.");
            return;
        }

        form.validate({
            rules: {
                nama_lengkap: {
                    required: true,
                    maxlength: 100
                },
                level_id: {
                    required: true
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
            submitHandler: function(form) {
                console.log("Kirim update user via AJAX...");

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            closeModal();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataUser.ajax.reload();
                        } else {
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
                const name = element.attr('name');
                $('#error-' + name).text(error.text());
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    }
</script>
