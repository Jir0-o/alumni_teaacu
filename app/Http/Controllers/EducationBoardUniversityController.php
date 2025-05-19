<?php

namespace App\Http\Controllers;

use App\Models\EducationBoardUniversity;
use Illuminate\Http\Request;

class EducationBoardUniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetBoard()
    {
        $data = EducationBoardUniversity::all();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxStoreBoard($board_university_name)
    {
        $board = new EducationBoardUniversity();
        $board->board_university_name = $board_university_name;
        $board->save();

        $data = EducationBoardUniversity::all();
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
     * @param  \App\Models\EducationBoardUniversity  $educationBoardUniversity
     * @return \Illuminate\Http\Response
     */
    public function show(EducationBoardUniversity $educationBoardUniversity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationBoardUniversity  $educationBoardUniversity
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationBoardUniversity $educationBoardUniversity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationBoardUniversity  $educationBoardUniversity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationBoardUniversity $educationBoardUniversity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationBoardUniversity  $educationBoardUniversity
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationBoardUniversity $educationBoardUniversity)
    {
        //
    }
}
