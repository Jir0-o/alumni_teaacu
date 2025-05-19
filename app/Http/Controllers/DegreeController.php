<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function add_degress(Request $request){
        $validator = Validator::make($request->all(), [
            'year' => 'required',
            'institute_name' => 'required',
            'degrees' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postdata = new Degree;
        $postdata->degrees = $request->degrees;
        $postdata->institute_name = $request->institute_name;
        $postdata->year = $request->year;
        $postdata->person_id  = $request->person_id ;
        $postdata->save();
        return response()->json([
            'status'=>200,
            'success'=>'Add Successfully'
        ]);
       }
     }

     public function get_degrees($id){
        $getDegrees = Degree::where('person_id',$id)->orderby('year','desc')->get();
        if($getDegrees){
            return response()->json([
                'getDegrees'=>$getDegrees
            ]);
        }
        else{
            return response()->json([
                'getDegrees'=>NULL
            ]);
        }
     }

     public function update_degrees(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'year' => 'required',
            'institute_name' => 'required',
            'degrees' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
            $postdata = Degree::find($id);
            $postdata->degrees = $request->degrees;
            $postdata->institute_name = $request->institute_name;
            $postdata->year = $request->year;
            $postdata->person_id  = $request->person_id ;
            $postdata->save();
        return response()->json([
            'status'=>200,
            'success'=>'Update Successfully'
        ]);
       }
     }

     //delete Degrees

     public function delete_degrees($id){
        $getDegrees =Degree::find($id);
        $getDegrees->delete();
        return response()->json([
            'status'=>200,
            'delete'=>'Delete Successfully'
        ]);
     }
     public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\Models\Degree  $degree
     * @return \Illuminate\Http\Response
     */
    public function show(Degree $degree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Degree  $degree
     * @return \Illuminate\Http\Response
     */
    public function edit(Degree $degree)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Degree  $degree
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Degree $degree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Degree  $degree
     * @return \Illuminate\Http\Response
     */
    public function destroy(Degree $degree)
    {
        //
    }
}
