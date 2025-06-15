<form action="{{ url('/teknisi/profile/update_ajax/' . $user->no_induk) }}" method="POST" id="form-edit-profile"
    enctype="multipart/form-data" class="space-y-4 font-inter">
    @csrf
    @method('PUT')

    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Edit Profile
        </div>

        <div class="p-6 space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold">No Induk</label>
                    <input type="text" name="no_induk" value="{{ $user->no_induk }}"
                        class="w-full border border-green-200 rounded p-2 outline-none" readonly>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Password
                        <span class="text-sm text-gray-500">(Kosongkan jika tidak diubah)</span></label>
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
                    <label class="block mb-1 font-semibold">Nomor Telepon</label>
                    <input type="text" name="nomor_telp" value="{{ $user->nomor_telp }}"
                        class="w-full border border-green-200 rounded p-2 outline-none">
                    <span id="error-nomor_telp" class="text-red-500 text-sm block mt-1"></span>
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
                    <label class="block mb-1 font-semibold">Foto Profil</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full border border-green-200 rounded p-2 outline-none cursor-pointer">
                    <span id="error-foto" class="text-red-500 text-sm block mt-1"></span>
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
        const form = $("#form-edit-profile");

        if (!form.length) {
            console.error("Form tidak ditemukan");
            return;
        }

        form.validate({
            rules: {
                nama_lengkap: {
                    required: true,
                    maxlength: 100
                },
                email: {
                    email: true
                },
                nomor_telp: {
                    maxlength: 15
                },
            },
            submitHandler: function(formEl) {
                const formData = new FormData(formEl);

                $.ajax({
                    url: formEl.action,
                    type: formEl.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            closeModal();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => location.reload());
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
                $('#error-' + element.attr('name')).text(error.text());
            },
            highlight: function(el) {
                $(el).addClass('is-invalid');
            },
            unhighlight: function(el) {
                $(el).removeClass('is-invalid');
            }
        });
    }
</script>
