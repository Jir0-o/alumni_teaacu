<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Committee;
use App\Models\LeadershipMessage;
use App\Models\Member;
use App\Models\Gallery;
use App\Models\OurGallery;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ImportantComLink;
use App\Models\importantLinks;
use App\Models\Person;
use App\Models\PopupNotice;
use App\Models\Role;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persons = newUsers();
        $registered = RegisteredUsers();
        $registeredCount = RegistereUserCount();
        return view('pages.users',compact(['persons','registered','registeredCount']));
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
    public function dashboard()
    {
        $user = totalUser();
        $notice = totalNotice();
        $event = totalEvent();
        $totalCommittee = Committee::count('id');
        $getCommittee = Committee::orderby('id', 'desc')->get();
        $totalCommitteeMember = Member::count('id');
        $newNotice = NewNotice();
        $allNotice = AllNoticeShow(); 
        $persons = newUsers();
        $registered = RegisteredUsers();
        $registeredCount = RegistereUserCount();
        $newEvent = NewEvent();
        $allEvent = AllEventShow();
        $getGalleryData = Gallery::orderby('id','desc')->get();
        $links = importantLinks::all();
        $users = User::with('roles')->get();
        $roles = Role::all(); // Pass all roles
        $getCommitteeMember = Member::join('committees', 'members.committee_id', '=', 'committees.id')
                ->select('members.*', 'committees.name')
                ->orderby('priority', 'asc')
                ->get();

        $peopleName = Person::with(['user'])
            ->whereHas('user', function ($query) {
                $query->where('is_active', 1);
            }) 
            ->get();

        $userRequest = User::where('status', 5)->get();
        
        return view('backend.dashboard.index',compact([
                'getGalleryData', 
                'user',
                'notice',
                'event',
                'totalCommittee',
                'getCommittee',
                'totalCommitteeMember',
                'newNotice',
                'allNotice',
                'persons',
                'registered',
                'registeredCount',
                'newEvent',
                'allEvent',
                'links',
                'getCommitteeMember',
                'peopleName',
                'users',
                'roles',
                'userRequest',
            ])
        );
    }

    public function frontend()
    {
        $user = totalUser();
        $notice = totalNotice();
        $event = totalEvent();
        $totalCommittee = Committee::count('id');
        $getCommittee = Committee::orderby('id', 'desc')->get();
        $totalCommitteeMember = Member::count('id');
        $newNotice = NewNotice();
        $allNotice = AllNoticeShow(); 
        $persons = newUsers();
        $registered = RegisteredUsers();
        $registeredCount = RegistereUserCount();
        $newEvent = NewEvent();
        $allEvent = AllEventShow();
        $getGalleryData = OurGallery::orderby('id','desc')->get();
        $links = importantLinks::all();
        $users = User::with('roles')->get();
        $roles = Role::all(); // Pass all roles
        $getCommitteeMember = Member::join('committees', 'members.committee_id', '=', 'committees.id')
                ->select('members.*', 'committees.name')
                ->orderby('priority', 'asc')
                ->get();

        $peopleName = Person::with(['user'])
            ->whereHas('user', function ($query) {
                $query->where('status', 3);
            })
            ->get();

        $popupNotices = PopupNotice::all();

        $about = About::where('is_active',1)->first();

        $message = LeadershipMessage::first();

        $getHomeGalleryData = Gallery::orderby('id','desc')->get();

        return view('backend.frontend.index',compact([
                'getGalleryData', 
                'user',
                'notice',
                'event',
                'totalCommittee',
                'getCommittee',
                'totalCommitteeMember',
                'newNotice',
                'allNotice',
                'persons',
                'registered',
                'registeredCount',
                'newEvent',
                'allEvent',
                'links',
                'getCommitteeMember',
                'peopleName',
                'users',
                'roles',
                'popupNotices',
                'about',
                'message',
                'getHomeGalleryData'
            ])
        );
    }

    public function upload_cips(Request $request) {
        $validated = $request->validate([
            'link' => 'required|string|max:255',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        ]); 

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();  
            $image->move(public_path('imp_link_img'), $imageName);  
            // frontend/images

            ImportantLinks::create([
                'link' => $validated['link'],
                'img_path' => $imageName,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Link created successfully.');
    }

    public function cips_update(Request $request) {
        $validated = $request->validate([
            'link' => 'required|string|max:255',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        $link = ImportantLinks::findOrFail($request->id);

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();  
            $image->move(public_path('imp_link_img'), $imageName);  

            // Update the image path in the $validated array
            $validated['img_path'] = $imageName;
        }

        $link->update($validated);

        return redirect()->route('dashboard')->with('success', 'Link update successfully.');
    }

    // delete data from ImportantComLink 
    public function delete_cips($id) {
        $data = ImportantLinks::find($id);
        $data->delete();
        return redirect()->route('dashboard')->with('success', 'Link deleted successfully.');
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
    public function AllNotice()
    {

    }
    public function AllEvent()
    {

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
        try {
            $user = User::findOrFail($id);
    
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'cips_number' => 'unique:people,alumni_id,' . $id,
                'roles' => 'array'
            ]);
    
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $person = Person::where('user_id', $id)->first();
            if ($person) {
                $person->update([
                    'alumni_id' => $request->cips_number,
                ]);
            }
    
            $user->syncRoles(Role::whereIn('id', $request->roles)->pluck('name')->toArray());
    
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect(route('userList'));
    }
public function approve($id)
{
    $user = User::find($id);

    $user->status = 3;
    $user->role = 2; 
    $user->is_active = 1; 
    $user->syncRoles(['Member']);
    $user->save();

    $person = Person::where('user_id', $id)->first();
    if ($person) {
        $person->status = 3;
        $person->is_active = 1;
        $person->cips_membership_status = 'Member';

        if (!$person->alumni_id) {
            $lastAlumni = Person::whereNotNull('alumni_id')
                ->orderByDesc('alumni_id')
                ->first();

            if ($lastAlumni && preg_match('/TEAACU(\d+)/', $lastAlumni->alumni_id, $matches)) {
                $nextNumber = (int)$matches[1] + 1;
            } else {
                $nextNumber = 1;
            }

            $person->alumni_id = 'TEAACU' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        $person->save();
    }

    return redirect(route('dashboard'));
}


    public function demote($id)
    {
        $user = User::find($id);
        $user->role = 0;
        $user->save();
        return redirect(route('userList'));
    }
    public function promote($id)
    {
        $user = User::find($id);
        $user->role = 1; //super admin
        $user->save();
        return redirect(route('userList'));
    }
    public function return($id)
    {
        $user = User::find($id);
        $user->status = 1; 
        $user->save();
        $person = Person::where('user_id', $id)->first();
        if ($person) {
            $person->status = 1; 
            $person->save();
        }
        return redirect(route('dashboard'));
    }
}
