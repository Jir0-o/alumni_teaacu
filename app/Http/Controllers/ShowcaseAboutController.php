<?php

namespace App\Http\Controllers;

use App\Models\ShowcaseAbout;
use Illuminate\Http\Request;

class ShowcaseAboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getForProfile = person();
        $countUser = NewUserCount();
        $abouts = getAbouts();
        return view('pages.about',compact(['getForProfile','countUser','abouts']));
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
        $about = new ShowcaseAbout;
        $about->first_section = $request['first_section'];
        $about->second_section = $request['second_section'];
        $about->third_section = $request['third_section'];
        $about->fourth_section = $request['fourth_section'];
        $about->isActive = $request['isActive'];
        $about->save();
        return redirect(route('adminAbout'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShowcaseAbout  $showcaseAbout
     * @return \Illuminate\Http\Response
     */
    public function show(ShowcaseAbout $showcaseAbout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShowcaseAbout  $showcaseAbout
     * @return \Illuminate\Http\Response
     */
    public function edit(ShowcaseAbout $showcaseAbout, $id)
    {
        $getForProfile = person();
        $countUser = NewUserCount();
        $about = ShowcaseAbout::find($id);
        return view('pages.aboutEdit',compact(['getForProfile','countUser','about']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShowcaseAbout  $showcaseAbout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $about = ShowcaseAbout::find($id);
        $about->first_section = $request['first_section'];
        $about->second_section = $request['second_section'];
        $about->third_section = $request['third_section'];
        $about->fourth_section = $request['fourth_section'];
        $about->isActive = $request['isActive'];
        $about->save();

        return redirect(route('adminAbout'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShowcaseAbout  $showcaseAbout
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShowcaseAbout $showcaseAbout, $id)
    {
        $about = ShowcaseAbout::find($id);
        $about->delete();
        return redirect(route('adminAbout'));
    }
}
