<?php

namespace App\Http\Controllers\User;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UsertUpdaterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function serverSide()
    {
        return DataTables::of(User::orderBy('employee_id', 'DESC'))->addColumn('action', function ($row) {
            $actionBtn =
                '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';

            return $actionBtn;
        })->rawColumns(['action'])->make(true);
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
            return back()->with('success', 'User has been added');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Something wrong!');
        }
    }

    public function edit($id)
    {
        try {
            $data = User::where('employee_id', $id)->first();
            return view('user.edit', compact('data'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong! ');
        }
    }

    public function update(UsertUpdaterRequest $request, $id)
    {
        try {
            User::where('employee_id', $id)->update([
                'employee_id' => $request->employee_id,
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status
            ]);
            return redirect('users')->with('success', 'User has been updated');
        } catch (\Throwable $e) {
            return redirect('users')->with('error', 'Something wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            User::where('employee_id', $id)->delete();
            return back()->with('success', 'User has been deleted');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!' . $e->getMessage());
        }
    }

    public function lastLogin(Request $request)
    {
        try {
            $datas = User::where('last_login', '!=', null)->get();
            return view('user.lastlogin', compact('datas'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function downloadExampleUser()
    {
        return Excel::download(new UserExport, 'User-Tempalate.xlsx');
    }
}
