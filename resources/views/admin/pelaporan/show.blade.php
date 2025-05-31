<div class="space-y-6">
    <div class="bg-green-700 text-white font-bold p-6 rounded-t mb-3">
        Detail Fasilitas {{$pelaporan->kode_laporan}}
    </div>
    <div class="p-3 gap-6">
        <div class="mx-auto space-y-3 mb-3">
            <div class="space-y-5">
                <label class="font-semibold">Nama Fasilitas</label>
                <div class="p-3 w-full border border-success rounded">
                    <h1>{{$pelaporan->fasilitas->nama_fasilitas ?? '-'}} </h1>
                </div>
            </div>
            <div class="space-y-5">
                <label class="font-semibold">Ruangan</label>
                <div class="p-3 w-full border border-success rounded">
                    <h1>{{$pelaporan->fasilitas->ruangan->kode_ruangan ?? '-'}} </h1>
                </div>
            </div>
            <div class="space-y-5">
                <label class="font-semibold">Lantai</label>
                <div class="p-3 w-full border border-success rounded">
                    <h1>{{$pelaporan->fasilitas->ruangan->lantai->nama_lantai ?? '-'}} </h1>
                </div>
            </div>
            <div class="space-y-5">
                <label class="font-semibold">Gedung</label>
                <div class="p-3 w-full border border-success rounded">
                    <h1>{{$pelaporan->fasilitas->ruangan->gedung->gedung_nama ?? '-'}} </h1>
                </div>
            </div>
            <div class="space-y-5">
                <label class="font-semibold">Tanggal Laporan</label>
                <div class="p-3 w-full border border-success rounded">
                    <h1>{{$pelaporan->tanggal_laporan ?? '-'}} </h1>
                </div>
            </div>
            <div class="space-y-5">
                <label class="font-semibold">Deskripsi Kerusakan</label>
                <div class="p-3 w-full border border-success rounded">
                    <h1>{{$pelaporan->deskripsi_kerusakan ?? '-'}} </h1>
                </div>
            </div>
            <div class="space-y-5">
                <label class="font-semibold">Foto Kerusakan</label>
                <div class="p-3 w-full border border-success rounded min-h-30">
                    <h1>{{asset('') ?? '-'}} </h1>
                </div>
            </div>
            <div class="space-y-5">
                <label class="font-semibold">Status Validasi</label>
                <div class="p-3 w-full border border-success rounded">
                    <h1>{{$pelaporan->status_acc ?? '-'}} </h1>
                </div>
            </div>
        </div>
        <div class="flex justify-end space-x-4">
            <button type="button" class="button-warning" onclick="closeModal()">Kembali</button>
        </div>
    </div>
</div>