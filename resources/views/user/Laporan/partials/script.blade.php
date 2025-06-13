<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script>
function dropdownForm() {
    return {
        gedung_id: '',
        lantai_id: '',
        ruangan_id: '',
        fasilitas_id: '',

        selectedGedungText: '',
        selectedLantaiText: '',
        selectedRuanganText: '',
        selectedFasilitasText: '',

        lantaiList: [],
        ruanganList: [],
        fasilitasList: [],

        async loadLantai() {
        this.lantai_id = '';
        this.selectedLantaiText = '';
        const res = await fetch(`{{ url('/ajax/lantai') }}?gedung_id=${this.gedung_id}`);
        this.lantaiList = await res.json();
        this.ruanganList = [];
        this.fasilitasList = [];
    },

    async loadRuangan() {
        this.ruangan_id = '';
        this.selectedRuanganText = '';
        const res = await fetch(`{{ url('/ajax/ruangan') }}?gedung_id=${this.gedung_id}&lantai_id=${this.lantai_id}`);
        this.ruanganList = await res.json();
        this.fasilitasList = [];
    },

    async loadFasilitas() {
        this.fasilitas_id = '';
        this.selectedFasilitasText = '';
        const res = await fetch(`{{ url('/ajax/fasilitas') }}?ruangan_id=${this.ruangan_id}`);
        this.fasilitasList = await res.json();
    },


        init() {
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @elseif (session('failed'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('failed') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        }
    }
}
</script>