@extends('layouts.template')

@section('title', $page->title)

@section('header', $page->header)

@section('content')
    <div class="font-inter">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center my-5 gap-3 md:gap-0">
        <h1 class="font-bold text-xl">Daftar Gedung</h1>
        <div class="flex items-center gap-2">
            <label for="filter_gedung" class="text-lg font-bold">Filter</label>
            <select id="filter_gedung" name="filter_gedung"
                class="border border-success rounded text-D_grey p-2 outline-none w-full md:w-50">
                <option value="">- Semua -</option>
                    </select>
                </div>
                <button class="button1 cursor-pointer" onclick="modalAction('{{ url('/admin/gedung/create') }}')">
                    <span class="text-xl mr-2">+</span> Tambah
                </button>
            </div>
        </div>
        <div class="overflow-x-auto border-y-1 border-gray1">
            <table class="min-w-full text-sm text-left text-gray-700" id="tableGedung">
                <thead class="text-D_grey font-semibold uppercase text-xs">
                    <tr>
                        <th class="w-[50px] px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3 text-left">Nama Gedung</th>
                        <th class="w-[160px] px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-l-3">
                </tbody>
            </table>

        </div>
    </div>

    <div id="modalContainer" class="fixed inset-0 z-50 justify-center items-center bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded shadow-lg max-w-2xl w-full relative">
            <button onclick="closeModal()"
                class="absolute top-4.5 right-6 text-white hover:text-gray-700 text-2xl font-bold cursor-pointer">
                &times;
            </button>
            <div id="modalContent"></div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('modalContent').innerHTML = html;
                    document.getElementById('modalContainer').classList.remove('hidden');
                    document.getElementById('modalContainer').classList.add('flex');
                    document.getElementById('modalContainer').classList.add('autoAppear');

                    document.querySelectorAll('#modalContent script').forEach((script) => {
                        $.globalEval(script.innerText || script.textContent || script.innerHTML);
                    });

                    if (typeof initTambahValidasi === "function") {
                        initTambahValidasi();
                    }
                    if (typeof initEditValidasi === "function") {
                        initEditValidasi();
                    }
                    if (typeof initDeleteValidasi === "function") {
                        initDeleteValidasi();
                    }
                })
                .catch(error => {
                    console.error('Error fetching modal:', error);
                });
        }



        function closeModal() {
            document.getElementById('modalContainer').classList.remove('flex');
            document.getElementById('modalContainer').classList.add('hidden');
            document.getElementById('modalContent').innerHTML = '';
        }


        var dataGedung;
        $(document).ready(function() {
            dataGedung = $('#tableGedung').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('admin/gedung/list') }}",
                    type: "GET",
                    dataType: "json"
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "gedung_nama",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });


        $(document).on('submit', '#form-delete-gedung', function(e) {
            e.preventDefault();
            const form = this;
            const formData = $(form).serialize();

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            $('#modalContainer').addClass('hidden');
                            $('#modalContent').html('');
                            window.location.href = response.redirect;
                        });
                    } else {
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
                        title: 'Oops!',
                        text: 'Terjadi kesalahan saat menghapus data.'
                    });
                }
            });
        });


        $(document).on('submit', '#form-edit', function(e) {
            e.preventDefault();
            $('#error-gedung_nama').text('');
            $.ajax({
                url: this.action,
                type: this.method,
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            $('#modalContainer').addClass('hidden');
                            $('#modalContent').html('');
                            dataGedung.ajax.reload();
                        });
                    } else {
                        if (response.msgField) {
                            $.each(response.msgField, function(field, messages) {
                                $('#error-' + field).text(messages[0]);
                            });
                        }

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
                        text: 'Gagal memperbarui data.'
                    });
                }
            });
        });

        $(document).on('submit', '#form-gedung', function(e) {
            e.preventDefault();
            $('#error-gedung_nama').text('');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            $('#modalContainer').addClass('hidden');
                            $('#modalContent').html('');
                            dataGedung.ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $('#error-' + field).text(messages[0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: 'Harap periksa kembali input Anda.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Data gagal disimpan'
                        });
                    }
                }
            });
        });
    </script>
@endpush
