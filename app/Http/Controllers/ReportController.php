<?php

namespace App\Http\Controllers;
use App\Models\Education;
use App\Models\EducationBoardUniversity;
use App\Models\EducationInstitute;
use App\Models\EducationLevel;
use App\Models\Experience;
use App\Models\Family;
use App\Models\Holding;
use App\Models\Moholla;
use App\Models\Person;
use App\Models\SpecialAllowance;
use App\Models\SpecialAllowanceInformatio;
use App\Models\Village;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.reports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showData(Request $request)
    {
        $ward = $request['ward'];
        $village = $request['village'];
        $moholla = $request['moholla'];
        $holding = $request['holding'];
        $family = $request['family'];
        if($family){
            $persons = personByFamily($family);
            return view('backend.reports.view',compact(['persons']));
        }
        else if($holding){
            $persons = personByHolding($holding);
            return view('backend.reports.view',compact(['persons']));
        }
        else if($moholla){
            $persons = personByMoholla($moholla);
            return view('backend.reports.view',compact(['persons']));
        }
        else if($village){
            $persons = personByVillage($village);
            return view('backend.reports.view',compact(['persons']));
        }
        else{
            $persons = personByWard($ward);
            return view('backend.reports.view',compact(['persons']));
        }
            
        // return compact(['ward','village','moholla','holding','family']);
    }

    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }
}
