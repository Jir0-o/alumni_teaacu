<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Division;
use App\Models\District;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Thana;
use App\Models\Union;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexxx()
    {
        return view('backend.dashboard.index');
    }
    public function index()
    {
        $settings = Settings::first();
        if($settings){
            $thana_id =$settings->thanaId;
            $union_id = $settings->unionId;
            $district_id = $settings->districtId;
            $division_id = $settings->divisionId;
    
            $thanas = Thana::find($thana_id);
            $unions = Union::find($union_id);
            $districts = District::find($district_id);
            $divisions = Division::find($division_id);
    
            return view('backend.settings.view',compact(['settings','thanas','unions','districts','divisions']));
        }
        else
        {
            $divisions = Division::get();
            return view('backend.settings.create',compact(['divisions']));
        }
        
    }
    public function view()
    {
        $settings = Settings::first();
        if($settings){
            $thana_id =$settings->thanaId;
            $union_id = $settings->unionId;
            $district_id = $settings->districtId;
            $division_id = $settings->divisionId;
    
            $thanas = Thana::find($thana_id);
            $unions = Union::find($union_id);
            $districts = District::find($district_id);
            $divisions = Division::find($division_id);
    
            return view('backend.settings.view',compact(['settings','thanas','unions','districts','divisions']));
        }
        else
        {
            return view('backend.settings.view', compact(['settings']));
        }
        
    }
    public function settingsView(){
        $settings = Settings::first();
        return response()->json($settings);
    }
    public function SaveUpdate(Request $data, $id)
    {
        $settings_id = Crypt::decryptString($id);
        $data->validate([
            'name'=>'required',
            'address'=>'required',
            'powered_by'=>'required',
            'email'=>'required',
            'contact_number'=>'required',
            'app_url'=>'required',
            // 'logo_path'=>'required',            
        ]);
        $settings = Settings::find($settings_id);
        $unions = Union::find($settings->unionId);

        $unions->thana_id = $data['thanaId'];
        $unions->uni_name = $data['name'];
        $unions->save();

        $unionId = $unions->id;

        $settings->address = $data['address'];
        $settings->powered_by = $data['powered_by'];
        $settings->email = $data['email'];
        $settings->contact_number = $data['contact_number'];
        $settings->app_url = $data['app_url'];
        $settings->divisionId = $data['divisionId'];
        $settings->districtId = $data['districtId'];
        $settings->thanaId = $data['thanaId'];
        if ($file = $data->file('logo_path')) {
            $imageName = date("dmy") . $file->getClientOriginalName();
            $path = url('/') . "/backend/images/" . $imageName;
            $data->logo_path->move(base_path('/backend/images/'), $imageName);
            $settings->logo_path = $path;
        }
        // $settings->logo_path = $data['logo_path'];
        $settings->unionId = $unionId;
        $settings->save();

        return redirect()->route('settings.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $data)
    {
        $data->validate([
            'name'=>'required',
            'address'=>'required',
            'powered_by'=>'required',
            'email'=>'required',
            'contact_number'=>'required',
            'app_url'=>'required',
            // 'logo_path'=>'required',
            'divisionId'=>'required|numeric',
            'districtId'=>'required|numeric',
            'thanaId'=>'required|numeric'
            
        ]);

        $union = new Union;
        $union->uni_name = $data['name'];
        $union->thana_id = $data['thanaId'];
        $union->uni_is_active = 1;
        $union->save();

        $latestUnion = Union::latest()->first();
        $unionId = $latestUnion->id;

        $settings = new Settings;
        $settings->address = $data['address'];
        $settings->powered_by = $data['powered_by'];
        $settings->email = $data['email'];
        $settings->contact_number = $data['contact_number'];
        $settings->app_url = $data['app_url'];
        $settings->divisionId = $data['divisionId'];
        $settings->districtId = $data['districtId'];
        $settings->thanaId = $data['thanaId'];
        // $settings->logo_path = $data['logo_path'];
        if ($file = $data->file('logo_path')) {
            $imageName = date("dmy") . $file->getClientOriginalName();
            $path = url('/') . "/backend/images/" . $imageName;
            $data->logo_path->move(base_path('/backend/images/'), $imageName);
            $settings->logo_path = $path;
        }


        $settings->unionId = $unionId;
        $settings->save();

        return redirect()->route('settings.view');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings, $id)
    {
        $settings_id = Crypt::decryptString($id);
        $settings = Settings::find($settings_id);
        $unions = Union::find($settings->unionId);
        $districts = District::find($settings->districtId);
        $thanas = Thana::find($settings->thanaId);
        $divisions = Division::find($settings->divisionId);
        return view('backend.settings.update', compact(['settings','unions','thanas', 'districts', 'divisions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
