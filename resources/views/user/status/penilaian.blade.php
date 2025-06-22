<form action="{{ url('/tambah-umpan-balik') }}" method="POST" class="space-y-4 font-inter" id="tambah-periode">
    @csrf
    <style>
        .star{
            transition: color 0.2ms ease;
        }

        input[type="radio"]:checked ~ .star{
            color: gold;
        }

        input[type="radio"]:hover ~ .star{
            color: gold;
        }

        .star:hover,
        .star:hover ~ .star{
            color: gold;
        }
    </style>
    <div class="space-y-6">
        <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
            Beri Penilaian Perbaikan {{$rekomendasi->alternatif->laporan->fasilitas->nama_fasilitas}}
        </div>
        <div class="p-6 space-y-3">
            <div id="star-rating" class="flex space-x-1 justify-center flex-row-reverse">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{$i}}" name="skala_kepuasan" value="{{$i}}" hidden>
                    <label for="star{{$i}}" class="star text-5xl text-gray-300 cursor-pointer">&#9733;</label>
                @endfor
            </div>
            <div class="form-group">
                <label class="block mb-1 font-semibold">Ulasan</label>
                <textarea 
                name="komentar" 
                id="" 
                rows="5" 
                maxlength="2000"
                class="w-full border border-green-200 rounded p-2 outline-none"
                placeholder="Tuliskan deskripsi kerusakan..."></textarea>
            </div>
            <input type="text" name="rekomendasi_id" value="{{$rekomendasi->rekomendasi_id}}" hidden>
            <input type="text" name="no_induk" value="{{auth()->user()->no_induk}}" hidden>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition cursor-pointer">Tambah</button>
            </div>
        </div>
    </div>
</form>
<script>
    function initTambahKomentarValidasi() {  
        if (typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate belum ter-load!");
            return;
        }

        const form = $("#tambah-periode");
        if (form.length === 0) {
            console.error("Form #tambah-periode tidak ditemukan di DOM.");
            return;
        }

        form.validate({
            rules: {
                skala_kepuasan: {
                    required: true,
                },
                komentar: {
                    maxlength: 2000,
                },
                rekomendasi_id: {
                    required: true,
                },
                no_induk: {
                    required: true,
                    date: true
                }
            },
            submitHandler: function(form) {
                console.log("Validasi")
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
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    }
</script>