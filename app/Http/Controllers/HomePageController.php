<?php

namespace App\Http\Controllers;

use App\Models\EventGallery;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\Notice;
use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ImportantLinks;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getForProfile = Person::find(Auth::id());
        $getSlider = Gallery::where('is_active',1)->orderby('id','desc')->get();
        $galleryCount = $getSlider->count();
        $getMemberList = Member::where('showcase',1)->orderby('id','asc')->take(3)->get();
        $getMemberListCount = $getMemberList->count();
        $totalNotice = Notice::count('id');
        $totalEvent = EventGallery::count('id');
        $totalMember = Person::count('id');
        $countUser = NewUserCount();
        $about = getAbout();
        $links = ImportantLinks::all();
        return view('pages.homepage',compact(
            [
                'getForProfile',
                'about',
                'countUser',
                'getSlider',
                'totalNotice',
                'totalEvent',
                'totalMember',
                'galleryCount',
                'getMemberList',
                'getMemberListCount',
                'links',
            ]));
    }
    
    public function commmitteeDetails($id){
        $getCommitteeMember = Member::find(decrypt($id));
        return view('frontend.committee.show',compact(['getCommitteeMember']));
    }
    public function wait()
    {
        $getForProfile = Person::find(Auth::id());
        return view('pages.waiting',compact(['getForProfile']));
    }

    public function member()
    {
        $getForProfile = person();
        return view('pages.member',compact('getForProfile'));
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
