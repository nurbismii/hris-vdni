<?php

namespace App\Http\Controllers\User;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Models\employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function import()
    {
        return view('user.import');
    }

    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            User::create($request->all());
            DB::commit();
            return back()->with('success', 'Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Something wrong! ' . $e->getMessage());
        }
    }

    public function edit()
    {
        try {
            // $user = User::findorFail($id);
            return view('user.edit');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong! ' . $e->getMessage());
        }
    }

    public function downloadExampleUser()
    {
        return Excel::download(new UserExport, 'UserExample.xlsx');
    }
}
