<?php

namespace AscentCreative\CMS\Controllers\Admin;


use App\Http\Controllers\Controller;

use AscentCreative\CMS\Settings\SiteSettings;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class SettingsController extends Controller
{

   public function edit() {

        $settings = app(SiteSettings::class);

       return view('cms::admin.settings.edit')->with('model', $settings)->with('modelName','Settings');
   }

   public function store(Request $request) { //}, SiteSettings $settings) {

        $settings = app(SiteSettings::class);

        // $settings->site_name = $request->input('site_name');
        // $settings->site_active = $request->boolean('site_active');
       
        $settings->fill($request->all());

        $settings->save();

        session()->flash("Settings Updated");
        
        return redirect()->back();

   }


}