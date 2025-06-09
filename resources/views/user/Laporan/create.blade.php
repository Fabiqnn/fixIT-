@extends('layouts_user.template')

@section('content')
<div class="">
    <div class="bg-green-700 text-white text-lg font-bold p-4">
        <div class="w-full max-w-[1400px] mx-auto px-2 sm:px-6 md:px-8 lg:px-12 xl:px-20">
            <h1>Laporan Kerusakan</h1>
        </div>
    </div>
    
    <div class="w-full max-w-[1400px] mx-auto px-2 sm:px-6 md:px-8 lg:px-12 xl:px-20">

        @include('user.laporan.partials.errors')
        
        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    @include('user.laporan.partials.upload')
                    @include('user.laporan.partials.dropdown')
                </div>
        
                @include('user.laporan.partials.deskripsi')
        
                <div class="mt-8 flex justify-end">
                    <button class="bg-green-700 text-white px-6 py-2 rounded-md hover:bg-green-800 transition" type="submit">
                        Kirim
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    @include('user.laporan.partials.script')
@endpush
