@extends('layouts_user.template')

@section('title', 'Dashboard Mahasiswa | fixIT!')

@section('content')
    <h1>Selamat datang, {{ $user->nama_lengkap }}</h1>
    <p>Nomor Induk: {{ $user->no_induk }}</p>
    <p>Ini adalah halaman dashboard mahasiswa.</p>
@endsection
