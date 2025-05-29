<form action="{{ url('admin/user/store') }}" method="POST" class="space-y-4 font-inter" id="tambah-user">
    @csrf
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Tambah Data User
        </div>
        <div class="p-6 space-y-3">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">No Induk</label>
                    <input type="text" name="no_induk"
                        class="w-full border border-green-300 rounded p-2 outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <span id="error-no_induk" class="text-red-500 text-sm block mt-1"></span>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full border border-green-300 rounded p-2 outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <span id="error-password" class="text-red-500 text-sm block mt-1"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap"
                        class="w-full border border-green-200 rounded p-2 outline-none" required>
                    <span id="error-nama_lengkap" class="text-red-500 text-sm block mt-1"></span>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Level</label>
                    <select name="level_id" id="level_id"
                        class="w-full border border-green-200 rounded p-2 outline-none" required>
                        <option value="">-- Pilih Level --</option>
                        @foreach ($level as $l)
                            <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                        @endforeach
                    </select>
                    <span id="error-level_id" class="text-red-500 text-sm block mt-1"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="section-mahasiswa" style="display: none;">
                <div>
                    <label class="block mb-1 font-semibold">Jurusan</label>
                    <select name="jurusan_id" class="w-full border border-green-200 rounded p-2 outline-none">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($jurusan as $j)
                            <option value="{{ $j->jurusan_id }}">{{ $j->jurusan_nama }}</option>
                        @endforeach
                    </select>
                    <span id="error-jurusan_id" class="text-red-500 text-sm block mt-1"></span>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Prodi</label>
                    <select name="prodi_id" class="w-full border border-green-200 rounded p-2 outline-none">
                        <option value="">-- Pilih Prodi --</option>
                        @foreach ($prodi as $p)
                            <option value="{{ $p->prodi_id }}">{{ $p->prodi_nama }}</option>
                        @endforeach
                    </select>
                    <span id="error-prodi_id" class="text-red-500 text-sm block mt-1"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" name="email"
                        class="w-full border border-green-200 rounded p-2 outline-none">
                    <span id="error-email" class="text-red-500 text-sm block mt-1"></span>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Nomor Telepon</label>
                    <input type="text" name="nomor_telp"
                        class="w-full border border-green-200 rounded p-2 outline-none">
                    <span id="error-nomor_telp" class="text-red-500 text-sm block mt-1"></span>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">
                    Tambah
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    const MAHASISWA_LEVEL_ID = 1;

    function initTambahValidasi() {
        const form = $("#tambah-user");
        $('#level_id').on('change', function() {
            const isMahasiswa = parseInt($(this).val()) === MAHASISWA_LEVEL_ID;
            $('#section-mahasiswa').toggle(isMahasiswa);
            $('select[name="jurusan_id"], select[name="prodi_id"]').prop('required', isMahasiswa);
        });

        form.validate({
            rules: {
                no_induk: {
                    required: true,
                    minlength: 3
                },
                password: {
                    required: true,
                    minlength: 6
                },
                nama_lengkap: {
                    required: true
                },
                level_id: {
                    required: true
                },
                jurusan_id: {
                    required: function() {
                        return parseInt($('#level_id').val()) === MAHASISWA_LEVEL_ID;
                    }
                },
                prodi_id: {
                    required: function() {
                        return parseInt($('#level_id').val()) === MAHASISWA_LEVEL_ID;
                    }
                },
                email: {
                    email: true
                },
                nomor_telp: {
                    maxlength: 15
                }
            },
            submitHandler: function(form) {
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
            }
        });
    }

    $(document).ready(initTambahValidasi);
</script>
