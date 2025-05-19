<?php

namespace App\Http\Controllers;

use App\Models\EducationInstitute;
use Illuminate\Http\Request;

class EducationInstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetInstitute()
    {
        $data = EducationInstitute::all();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxStoreInstitute($institute_name)
    {
        $EducationInstitute = new EducationInstitute();
        $EducationInstitute->institute_name = $institute_name;
        $EducationInstitute->save();

        $data = EducationInstitute::all();
        return response()->json($data);
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
     * @param  \App\Models\EducationInstitute  $educationInstitute
     * @return \Illuminate\Http\Response
     */
    public function show(EducationInstitute $educationInstitute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationInstitute  $educationInstitute
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationInstitute $educationInstitute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationInstitute  $educationInstitute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationInstitute $educationInstitute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationInstitute  $educationInstitute
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationInstitute $educationInstitute)
    {
        //
    }
}
