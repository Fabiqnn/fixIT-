<?php

namespace App\Http\Controllers;

use App\Models\FasilitasModel;
use App\Models\GedungModel;
use App\Models\UserModels;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;



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
}
