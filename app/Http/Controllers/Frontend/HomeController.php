<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\LeadershipMessage;
use App\Models\Member;
use App\Models\Notice;
use App\Models\OurGallery;
use App\Models\Person;
use App\Models\Gallery;
use App\Models\EventGallery;
use App\Models\ImportantLinks;
use App\Models\PopupNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $getSlider = Gallery::where('is_active',1)->orderby('id','desc')->get();
        $galleryCount = $getSlider->count();
        $getMemberList = Member::where('showcase',1)->orderby('id','asc')->take(3)->get();
        $getMemberListCount = $getMemberList->count();
        $totalNotice = Notice::count('id');
        $totalEvent = EventGallery::count('id');
        $totalMember = Person::count('id');
        $about = getAbout();
        $links = ImportantLinks::all();
        $popupNotices = PopupNotice::where('is_active', 1)
        ->whereDate('end_date', '>=', Carbon::today())
        ->latest()
        ->get();
        $message = LeadershipMessage::first();

        $showAll = OurGallery::orderby('id','desc')->paginate(6);
        $event = OurGallery::where('type',1)->orderby('id','desc')->paginate(6);
        $lab = OurGallery::where('type',2)->orderby('id','desc')->paginate(6);
        $classroom = OurGallery::where('type',3)->orderby('id','desc')->paginate(6);

        return view('frontend.home.index', compact([
                'about',
                'getSlider',
                'totalNotice',
                'totalEvent',
                'totalMember',
                'galleryCount',
                'getMemberList',
                'getMemberListCount',
                'links',
                'popupNotices',
                'message',
                'showAll',
                'event',
                'lab',
                'classroom',
            ]));
    }

    public function show()
    {
        $getMemberList = Member::where('showcase',1)->orderby('id','asc')->take(3)->get();
        $getMemberListCount = $getMemberList->count();
        $totalNotice = Notice::count('id');
        $totalEvent = EventGallery::count('id');
        $totalMember = Person::count('id');
        $about = getAbout();
        $links = ImportantLinks::all();

        $aboutSection = About::where('is_active',1)->first();
        $showAll = OurGallery::orderby('id','desc')->paginate(6);
        $event = OurGallery::where('type',1)->orderby('id','desc')->paginate(6);
        $lab = OurGallery::where('type',2)->orderby('id','desc')->paginate(6);
        $classroom = OurGallery::where('type',3)->orderby('id','desc')->paginate(6);
        return view('frontend.about.index', compact([
                'about',
                'totalNotice',
                'totalEvent',
                'totalMember',
                'getMemberList',
                'getMemberListCount',
                'links',
                'aboutSection',
                'showAll',
                'event',
                'lab',
                'classroom',
            ]));
    }

    public function filterMembers(Request $request, $id, $category_name)
    {
        $query = Person::query()
            ->leftJoin('users', 'people.user_id', '=', 'users.id')
            ->where(function($q) {
                $q->whereNull('people.user_id') // include people with no user
                ->orWhere('users.is_active', 1); // or where user status is 3
        });

        // Apply filtering
        if ($category_name == 'Entrepreneur') {
            $query->where('career_type', 'Entrepreneur');
        } else {
            $query->where('member_sub_subcategory_id', $id);
        }

        // Apply search if exists
        if ($request->filled('name')) {
            $search = $request->name;
            $query->where(function($q) use ($search) {
                $q->where('people.name', 'like', "%$search%")
                ->orWhere('people.member_id', 'like', "%$search%")
                ->orWhere('people.position', 'like', "%$search%");
            });
        }

        $people = $query->orderBy('people.id', 'DESC')->paginate(10);

        return view('frontend.member.index', compact('people', 'id', 'category_name'));
    }

    public function member(Request $request) 
    {
        $people = Person::leftJoin('users','people.user_id','=','users.id')
                    ->where('role','!=','0')
                    ->orderby('people.id','DESC')
                    ->simplePaginate(5);
                    
        return view('frontend.member.index',compact('people'));
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }
    
    public function destroy(string $id)
    {
        //
    }
}
