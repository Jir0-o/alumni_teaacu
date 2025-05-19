<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Employment;
use App\Models\LanguageProficiency;
use App\Models\Person;
use App\Models\Skill;
use App\Models\User;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Member;
use App\Models\UserAccomplishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index()
    {
        $countUser = NewUserCount();
        $people = Person::leftJoin('users', 'people.user_id', '=', 'users.id')
            ->where('role', '!=', '0')
            ->orderby('people.id', 'DESC')
            ->simplePaginate(5);

        // return $people;
        $getForProfile = person();
        return view('pages.member', compact(['people', 'getForProfile', 'countUser']));
    }
    
    public function filter(Request $request)
    {
        $name = $request->name;
        $categoryId = $request->id;
        $categoryName = $request->category_name;

        $peopleQuery = Person::leftJoin('users', 'people.user_id', '=', 'users.id')
            ->leftJoin('institute_infos', 'people.id', '=', 'institute_infos.person_id')
            ->whereNull('institute_infos.to')
            ->where(function ($query) {
                $query->whereNull('people.user_id')
                    ->orWhere('users.is_active', 1);
        });


        // Apply category filter
        if ($categoryName === 'Entrepreneur') {
            $peopleQuery->where('people.career_type', 'Entrepreneur');
        } else {
            $peopleQuery->where('people.member_sub_subcategory_id', $categoryId);
        }

        // Apply name or keyword filter
        if ($name) {
            $peopleQuery->where(function ($query) use ($name) {
                $query->where('people.name', 'LIKE', '%' . $name . '%')
                    ->orWhere('people.alumni_id', 'LIKE', '%' . $name . '%')
                    ->orWhere('people.cips_membership_status', 'LIKE', '%' . $name . '%')
                    ->orWhere('users.cips', 'LIKE', '%' . $name . '%')
                    ->orWhere('institute_infos.designation', 'LIKE', '%' . $name . '%')
                    ->orWhere('institute_infos.organization', 'LIKE', '%' . $name . '%')
                    ->orWhere('institute_infos.address', 'LIKE', '%' . $name . '%');
            });
        }

        $people = $peopleQuery
            ->select('people.name','people.id','people.profileImage', 'people.alumni_id', 'people.cips_membership_status', 'users.cips','institute_infos.organization','institute_infos.designation')
            ->orderBy('institute_infos.form', 'DESC')
            ->get();

        $view = '';
        foreach ($people as $item) {
            $view .= view('frontend.member.member_card', compact('item'))->render();
        }

        return response()->json($view);
    }

    public function viewPerson($id)
    {
        $persons = viewById($id);
        $experiences = ExperienceById($id);
        $educations = EducationById($id);
        $degree = Degree($id);
        $getEducation = Education::where('person_id',Auth::id())->orderby('passing_year','desc')->get();
        $getAccomplishments = UserAccomplishment::where('user_id',Auth::id())->orderby('id','desc')->get();
        $getSkills = Skill::where('user_id',Auth::id())->orderby('id','desc')->get();
        $getLanguages = LanguageProficiency::where('user_id',Auth::id())->orderby('id','desc')->get();
        $getEmployment = Employment::where('user_id',Auth::id())->orderby('id','desc')->get();
        // $familymembers = FamilyMemberById($id);
        return view('frontend.member.show', compact([
                'degree', 
                'persons', 
                'experiences', 
                'educations', 
                'getEducation', 
                'getAccomplishments', 
                'getSkills', 
                'getLanguages', 
                'getEmployment'
            ])
        );
    }

    public function GetAllCommittee()
    {
        $getCommittee = Committee::where('isActive', 1)->get();
        if ($getCommittee) {
            return response()->json([
                'getCommittee' => $getCommittee
            ]);
        } else {
            return response()->json([
                'getCommittee' => NULL
            ]);
        }
    }

    public function addCommitteeMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'committee_member_name' => 'required',
            'cipsMemberId' => 'required',
            'position_held' => 'required',
            'committe_ID' => 'required',
            'priority' => 'integer|nullable',
            'committee_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
            $postCommitteeMember = new Member;
            $postCommitteeMember->committee_member_name = $request->committee_member_name;
            $postCommitteeMember->cipsMemberId = $request->cipsMemberId;
            $postCommitteeMember->designation = $request->position_held;
            $postCommitteeMember->committee_id  = $request->committe_ID;
            $postCommitteeMember->committee_type = $request->committee_type;
            if ($file = $request->file('imgPath')) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $path = "/backend/images/" . $imageName;
                $request->imgPath->move(base_path('/backend/images/'), $imageName);
                $postCommitteeMember->imgPath = $path;
            }

            if ($request->has('priority')) {
                $postCommitteeMember->priority = $request->priority;
            }

            $postCommitteeMember->save();
            return response()->json([
                'status' => 200,
                'success' => 'Add Successfully',

            ]);
        }
    }

    public function GetAllCommitteeMember(Request $request)
    {
        if ($request->ajax()) {
            $getCommitteeMember = Member::join('committees', 'members.committee_id', '=', 'committees.id')
                ->select('members.*', 'committees.name')
                ->orderby('priority', 'asc')
                ->get();
            // dd($getCommitteeMember);

            return DataTables::of($getCommitteeMember)
                ->addIndexColumn()
                ->addColumn('imgPath', function ($row) {

                    return '<img src="' . $row->imgPath . '" border="0" width="40" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="committee_member_edit btn btn-outline-primary btn-sm editProduct"><i class="bi bi-pencil"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-outline-danger btn-sm committee_member_delete"><i class="bi bi-file-x-fill"></i></a>';
                    if ($row->showcase == 0) {
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="showCase" class="btn btn-outline-success btn-sm committee_member_showCase"><i class="bi bi-toggle-on"></i></a>';
                    } else {
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="showCase" class="btn btn-outline-warning btn-sm committee_member_showCaseHide"><i class="bi bi-toggle-off"></i></a>';
                    }

                    return $btn;
                })
                ->addColumn('showcase', function ($row) {
                    if ($row->showcase == 1) {
                        return '<span class="badge rounded-pill bg-success">Show</span>';
                    } else {
                        return '<span class="badge rounded-pill bg-danger">Hide</span>';
                    }
                })
                ->addColumn('priority', function ($row) {
                    return $row->priority ? $row->priority : 'N/A'; // Default to 'N/A' if null
                })
                ->rawColumns(['action', 'showcase', 'imgPath'])
                ->make(true);
        }
    }

    //Edit Committee Member
    public function editCommitteeMember($id)
    {
        $getdata  = Member::find($id);
        return response()->json([
            'getdata' => $getdata,
            'status' => 200
        ]);
    }

    //Update Committee Member
    public function updateCommitteeMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'committee_member_name_update' => 'required',
            'cipsMemberIdUpdate' => 'required',
            'position_held_update' => 'required',
            'committe_ID_update' => 'required',
            'priority' => 'integer|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
            $postCommitteeMember = Member::find($id);
            $imagePath = basename($postCommitteeMember->imgPath);
            $filePath = 'backend/images/' . $imagePath;
            if (!empty($postCommitteeMember->imgPath)) {
                $imagePath = basename($postCommitteeMember->imgPath);
                $filePath = 'backend/images/' . $imagePath;

                // Ensure the file exists and is not a directory
                if (is_file($filePath) && file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $postCommitteeMember->committee_member_name = $request->committee_member_name_update;
            $postCommitteeMember->cipsMemberId = $request->cipsMemberIdUpdate;
            $postCommitteeMember->designation = $request->position_held_update;
            $postCommitteeMember->committee_id  = $request->committe_ID_update;
            if ($file = $request->file('update_committee_member_image')) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $path = url('/') . "/backend/images/" . $imageName;
                $request->update_committee_member_image->move(base_path('/backend/images/'), $imageName);
                $postCommitteeMember->imgPath = $path;
            }

            if ($request->has('priority')) {
                $postCommitteeMember->priority = $request->priority;
            }

            $postCommitteeMember->save();
            return response()->json([
                'status' => 200,
                'success' => 'Update Successfully',

            ]);
        }
    }

    //Delete Committee Member

    public function deleteCommitteeMember($id)
    {
        $getdata = Member::find($id);
        if ($getdata->imgPath) {
            $imagePath = basename($getdata->imgPath);
            $filePath = 'backend/images/' . $imagePath;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $getdata->delete();
        return response()->json([
            'status' => 200,
            'delete' => 'Delete Successfully'
        ]);
    }

    public function committeeMemberShow($id)
    {
        $getCommitteeMember = Member::where('committee_id', $id)
            ->orderby('priority', 'asc')
            ->get();

        $totalCommitteeMember = $getCommitteeMember->count('id');
        return response()->json([
            'getCommitteeMember' => $getCommitteeMember,
            'totalCommitteeMember' => $totalCommitteeMember
        ]);
    }
    //Member Front Show
    public function enable($id)
    {
        $getCommitteeMember = Member::find($id);
        $getCommitteeMember->showcase = 1;
        $getCommitteeMember->save();
        return response()->json([
            'status' => 200,
            'success' => 'Active Front Show Successfully',

        ]);
    }

    //Member Front Hide
    public function disabled($id)
    {
        $getCommitteeMember = Member::find($id);
        $getCommitteeMember->showcase = 0;
        $getCommitteeMember->save();
        return response()->json([
            'status' => 200,
            'success' => 'DeActive  Successfully',

        ]);
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
