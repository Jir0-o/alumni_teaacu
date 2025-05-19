<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAccomplishment;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    function index() 
    {
        $getPublication = UserAccomplishment::all();
        return view('frontend.publication.index', compact('getPublication'));
    }
}
