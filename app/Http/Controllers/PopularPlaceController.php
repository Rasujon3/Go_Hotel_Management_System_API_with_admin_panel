<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Exception;
use Illuminate\Http\Request;

class PopularPlaceController extends Controller
{
    public function index()
    {
        return view('admin.popularPlaces.index');
    }
    public function create()
    {
        return view('admin.popularPlaces.create');
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }
    public function edit()
    {
        return view('admin.popularPlaces.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }
}
