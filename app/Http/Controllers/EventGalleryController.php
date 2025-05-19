<?php

namespace App\Http\Controllers;

use App\Models\EventGallery;
use App\Models\EventRegistration;
use App\Models\EventPic;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = EventAlongWithPicture();
        $pics = EventPic::get();

        return view('frontend.event.index',compact(['events','pics']));
    }
    
    public function MyEvent()
    {
        $pics = EventPic::get();
        $user = Auth::user();
        $events = EventGallery::where('created_by',$user->id)
                    ->orderby('id','DESC')
                    ->simplepaginate(10);

        return view('frontend.event.my_event',compact(['events','pics']));
    }
    
    public function MyEventAction($id)
    {
        $countUser = NewUserCount();
        $getForProfile = person();
        $pics = EventPic::get();
        $event = EventGallery::find($id);
        return view('pages.eventEdit',compact(['event','pics','getForProfile','countUser']));
    }

    public function allEventRegistration()
    {
        $getForProfile = person();
        $events = EventGallery::where('isActive','=',1)
                    ->where('reg_enable','=',1)
                    ->select('id','title')
                    ->get();

        $countUser = NewUserCount();
        
        return view('pages.eventRegistrationList',compact(['getForProfile','events','countUser'])); 
    }

    // all registrad member list
    public function eventRegMemberList(Request $request)
    {
        $eventId = $request->get('event_id');
        $members = EventRegistration::join('people as p', 'event_registration.user_id', '=', 'p.id')
                    ->join('event_galleries as eg', 'event_registration.event_id', '=', 'eg.id')
                    ->where('event_registration.event_id', $eventId)
                    ->select('p.name', 'eg.title', 'event_registration.reg_date', 'event_registration.payment_method', 'event_registration.trx_number', 'reg_amount')
                    ->get();

        $total_amount = $members->sum('reg_amount');

        $count = $members->count('reg_amount');

        return response()->json([
            'members' => $members,
            'total_amount' => $total_amount,
            'count' => $count,
        ]);
    }
    
    public function UpdateEvent(Request $request, $id)
    {   
        $getForProfile = person();
        $event = EventGallery::find($id);
        $event->title = $request['title'];
        $event->reg_valid_date = $request->validTill;
        $event->isActive = $request['isActive'];
        $event->save();
        $images = $request->file('images');
        if($images){
            foreach ($images as $image) {
            $filename = date("dmy") . $image->getClientOriginalName();
            $path = url('/') . "/backend/images/" . $filename;
            $image->move(base_path('/backend/images/'), $filename);
            $dbImage = new EventPic;
            $dbImage->imgPath = $path;
            $dbImage->event_id = $event->id;
            $dbImage->save();
          }
        }
        
        return redirect(route('event'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        if($request['validTill'])
        {
            $regEnable = 1;
        }
        else
        {
            $regEnable = 0;
        }
        if($request['regAmount'])
        {
            $regAmount = $request['regAmount'];
        }
        else
        {
            $regAmount = '0';
        }
        $user = Auth::user();
        $event = new EventGallery;
        $event->title = $request['title'];
        $event->reg_enable = $regEnable;
        $event->reg_amount = $regAmount;
        $event->reg_valid_date = $request['validTill'];
        $event->created_by = $user->id;
        $event->save();
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $filename = date("dmy") . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'backend/images/' . $filename;

                // Move to public folder
                $image->move(public_path('backend/images'), $filename);

                // Save path to database
                $dbImage = new EventPic;
                $dbImage->imgPath = $path;
                $dbImage->event_id = $event->id;
                $dbImage->save();
            }
        }
        return redirect(route('frontend.event'));
    }
    
    public function eventRegister(Request $request)
    {
        // dd($request);
        
        $register = new EventRegistration();
        $register->event_id = $request['eventID'];
        $register->user_id = Auth::user()->id;
        $register->reg_date = now();
        $register->payment_method = $request['paymentmethod'];
        $register->trx_number = $request['trxNumber'];
        $status = $register->save();

        $eventGallery = EventGallery::find($request['eventID']);
        $eventGallery->status = 1;
        $eventGallery->save();
        
        if($status)
        { 
            return redirect()->back()->with("Success", "Event Registration Successfully");
        }
    }

    
    public function show(EventGallery $eventGallery)
    {
       
    }

    
    public function edit(EventGallery $eventGallery)
    {
        //
    }

    
    public function update(Request $request, EventGallery $eventGallery)
    {
        //
    }

    
    public function AllEvent(){
        $newEvent = NewEvent();
        $allEvent = AllEventShow();
        return view('backend.dashboard.index',compact(['newEvent','allEvent']));
    }
    public function approve($id)
    {
        $event = EventGallery::find($id);
        $event->isActive = 1;
        $event->save();
        return redirect()->back()->with("Success", "Event Approved Successfully");
    }
    public function Deactivate($id)
    {
        $event = EventGallery::find($id);
        $event->isActive = 2;
        $event->save();
        return redirect()->back()->with("warning", "Event Status Change Successfully");
    }
    public function destroy($id)
    {
        $event = EventGallery::find($id);
        $event->delete();
        return redirect()->back()->with("Success", "Event Delete Successfully");
    }

    public function deleteEvent($id)
    {
        $event = EventGallery::find($id);
        $event->delete();
        return redirect()->back()->with("Success", "Event Delete Successfully");
    }

    public function registerEvent()
    {
        $events = EventGallery::with('registrations')->orderBy('id','DESC')->get();

        return view('frontend.event.view_registration',compact(['events']));
    }

}
