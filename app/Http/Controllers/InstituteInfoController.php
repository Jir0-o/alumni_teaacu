<?php

namespace App\Http\Controllers;

use App\Models\InstituteInfo;
use App\Models\InstType;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class InstituteInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetInstitute()
    {
        $data = InstituteInfo::all();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetInstituteType()
    {
        $data = InstType::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStoreInstitute(Request $request)
    {
        $company = new InstituteInfo();
        $company->name = $request->new_company_name;
        $company->inst_type_id = $request->inst_type_id;
        $company->trade_lic_number = $request->trade_lic_number;
        $company->trade_lic_validity = $request->trade_lic_validity;
        $company->owners_address = $request->owners_address;
        $company->address = $request->address;
        $company->number_of_employees = $request->number_of_employees;
        $company->owners_name = $request->owners_name;
        $company->established_year = $request->established_year;
        $company->notes = $request->notes;
        $company->nature_of_business = $request->nature_of_business;
        $company->save();

        $data = InstituteInfo::all();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstituteInfo  $instituteInfo
     * @return \Illuminate\Http\Response
     */
    public function show(InstituteInfo $instituteInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstituteInfo  $instituteInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(InstituteInfo $instituteInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstituteInfo  $instituteInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstituteInfo $instituteInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstituteInfo  $instituteInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstituteInfo $instituteInfo)
    {
        //
    }
}
