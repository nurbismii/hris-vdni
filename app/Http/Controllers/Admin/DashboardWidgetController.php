<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDashboardRequest;
use App\Models\parameter_dashboard;

class DashboardWidgetController extends Controller
{
    public function index()
    {
        try {
            $datas = parameter_dashboard::orderBy('id', 'DESC')->get();
            return view('admin.customize_setting.dashboard.index', compact('datas'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function store(StoreDashboardRequest $request)
    {
        try {
            $status = $request->status;
            $data = parameter_dashboard::where('status', $status)->first();
            if ($data) {
                if ($data->status == '1') {
                    $data->where('status', $data->status)->update([
                        'status' => '0',
                    ]);
                    parameter_dashboard::create($request->all());
                    return back()->with('success', 'Content Dasboard has been added');
                }
            }
            parameter_dashboard::create($request->all());
            return back()->with('success', 'Content Dasboard has been added');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function update(StoreDashboardRequest $request, $id)
    {

        try {
            $data = parameter_dashboard::where('status', $request->status)->first();
            if ($data) {
                if ($data->status == '1') {
                    $data->where('status', $data->status)->update([
                        'status' => '0',
                    ]);
                }
            }
            parameter_dashboard::where('id', $id)->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'status'  => $request->status
            ]);
            return back()->with('success', 'Content Dasboard has been updated');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            parameter_dashboard::where('id', $id)->delete();
            return back()->with('success', 'Content Dashboard has been deleted');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }
}
