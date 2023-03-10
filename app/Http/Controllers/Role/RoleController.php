<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return view('role.index');
    }

    public function create()
    {
        return view('role.create');
    }
}
