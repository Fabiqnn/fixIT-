@extends('layouts_user.template')

@section('title', 'Dashboard Mahasiswa | fixIT!')

@section('content')
    <div class="w-full h-35 px-3 mb-5">
        <div class="w-full h-full relative">
            <img src="{{ asset('assets/bg1.jpg') }}" alt="" class="h-full w-full object-cover rounded-b-lg">
            <div class="bg-black/50 h-full w-full left-0 absolute top-0 rounded-b-lg"></div>
            <div class="absolute inset-0 flex items-center pl-5 ">
                <h1 class="text-white font-semibold text-2xl tracking-wide">Dashboard</h1>
            </div>
        </div>
    </div>
    <div>
        <div class="h-screen m-3 border border-gray-300 p-6 rounded-lg shadow-md flex">
            <div>
                <div class="flex gap-5">
                    <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-700 pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" id="search" placeholder="Search"
                                class="pl-10 w-full py-2 bg-gray-100 rounded focus:outline-none focus:ring-green-700 text-sm placeholder:text-green-700" />
                        </div>
                    <div class="flex items-center gap-2">
                        <select id="gedung_id" name="gedung_id"
                            class="border border-success rounded text-D_grey p-2 outline-none w-50">
                            <option value="">- Filter -</option>
                            {{-- @foreach ($gedung as $g)
                                <option value="{{ $g->gedung_id }}">{{ $g->gedung_nama }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
            </div>
            <div>
                
            </div>
        </div>
    </div>
@endsection
