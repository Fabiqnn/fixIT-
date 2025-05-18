<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $page = (object) [
            'title' => 'Dashboard',
            'header' => 'Dashboard'
        ];

        $activeMenu = 'dashboard';

        return view('admin.dashboard', ['page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function fasilitas()
    {
        $page = (object) [
            'title' => 'Fasilitas',
            'header' => 'Manajemen Fasilitas'
        ];

        $activeMenu = 'fasilitas';

        return view('admin.fasilitas.index', ['page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function user()
    {
        $page = (object) [
            'title' => 'User',
            'header' => 'User Management'
        ];

        $activeMenu = 'user';

        return view('admin.userManagement', ['page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function tes()
    {


        return view('admin.userCreateAjax');
    }

    public function createAjax()
    {
        return view('admin.userCreateAjax');
    }

    public function building()
    {
        $page = (object) [
            'title' => 'Building',
            'header' => 'Building Management'
        ];

        $activeMenu = 'building';

        return view('admin.building', ['page' => $page, 'activeMenu' => $activeMenu]);
    }
}
