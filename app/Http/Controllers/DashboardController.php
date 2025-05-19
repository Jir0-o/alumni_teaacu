<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\Holding;
use App\Models\Moholla;
use App\Models\Village;
use App\Models\Union;
use App\Models\Ward;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $villages = Village::where('village_is_active',1)->count();
        $families = Family::where('fam_is_active',1)->count();
        $holdings = Holding::where('hold_is_active',1)->count();
        $mohollas = Moholla::where('moholla_is_active',1)->count();
        $wards = Ward::where('ward_is_active',1)->count();
        $people = Person::count();
        $birthThisMonth = Person::whereMonth('dob', Carbon::now()->month)->whereYear('dob',Carbon::now()->year)->count();
        $deathThisMonth = Person::whereMonth('dod', Carbon::now()->month)->whereYear('dod',Carbon::now()->year)->count();
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('backend.dashboard.index', compact(['villages','families','holdings','mohollas','wards','people','birthThisMonth','deathThisMonth','users','roles']));
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
