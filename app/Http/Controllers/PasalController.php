<?php

namespace App\Http\Controllers;

use App\Models\Pasal;
use Illuminate\Http\Request;

class PasalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datas = Pasal::all();
        return view('customize_setting.pasal.index', compact('datas'))->with('no');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Pasal::create([
            'pasal' => $request->pasal,
            'bunyi' => $request->bunyi,
        ]);
        return back()->with('success', 'Pasal added successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Pasal::where('id', $id)->update([
            'pasal' => $request->pasal,
            'bunyi' => $request->bunyi,
        ]);
        return back()->with('success', 'Pasal updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Pasal::find($id)->delete();
        return back()->with('success', 'Pasal deleted successfully');
    }
}
