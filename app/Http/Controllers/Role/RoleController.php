<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Models\role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {

        return view('role.index');
    }

    public function create()
    {
        $datas = role::all();
        return view('role.create', compact('datas'));
    }

    public function store(RoleStoreRequest $request)
    {
        try {
            role::create($request->all());
            return back()->with('success', 'Successfully added role');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to add role' . $e->getMessage());
        }
    }

    public function update(role $role, $id, RoleStoreRequest $request)
    {
        try {
            $role->find($id)->update($request->all());
            return back()->with('success', 'Successfully updated role');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to update role' . $e->getMessage());
        }
    }

    public function destroy(role $role, $id)
    {
        try {
            $role->find($id)->delete();
            return back()->with('success', 'Successfully deleted role');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to delete role' . $e->getMessage());
        }
    }
}
