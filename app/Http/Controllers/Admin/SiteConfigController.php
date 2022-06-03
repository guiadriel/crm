<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteConfig;
use Illuminate\Http\Request;

class SiteConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:edit site info', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteConfig $siteConfig)
    {
        return view('admin.site.edit', ['siteconfig' => $siteConfig]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteConfig $siteConfig)
    {
        $siteConfig->address = $request->address;
        $siteConfig->number = $request->number;
        $siteConfig->district = $request->district;
        $siteConfig->city = $request->city;
        $siteConfig->state = $request->state;
        $siteConfig->phone = $request->phone;
        $siteConfig->email = $request->email;

        if ($siteConfig->save()) {
        }

        return redirect()->route('admin.siteconfig.edit', ['site_config' => $siteConfig->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteConfig $siteConfig)
    {
    }
}
