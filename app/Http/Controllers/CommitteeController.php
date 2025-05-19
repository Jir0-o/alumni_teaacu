<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allCommittee(Request $request)
    {
        $getForProfile = person();
        $countUser = NewUserCount();
        // if ($request->ajax()) {
        //     $getCommittee = Committee::orderby('id', 'desc')->get();
        //     return DataTables::of($getCommittee)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($row) {

        //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="committee_edit btn btn-outline-primary btn-sm editProduct"><i class="bi bi-pencil"></i></a>';

        //             $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-outline-danger btn-sm committee_delete"><i class="bi bi-file-x-fill"></i></a>';

        //             $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="show" class="btn btn-outline-warning btn-sm committee_member_show"><i class="bi bi-eye-fill"></i></a>';
        //             return $btn;
        //         })

        //         ->addColumn('isActive', function ($row) {
        //             if ($row->isActive == 1) {
        //                 return '<span class="badge rounded-pill bg-success">Active</span>';
        //             } else {
        //                 return '<span class="badge rounded-pill bg-danger">Inactive</span>';
        //             }
        //         })
        //         ->addColumn('to', function ($row) {
        //             if ($row->to == NULL) {
        //                 return date('Y-m-d');
        //             } else {
        //                 return $row->to;
        //             }
        //         })

        //         ->rawColumns(['action', 'isActive', 'to'])
        //         ->make(true);

        // }
        return view('frontend.committee.committeMainView', compact(['getForProfile', 'countUser']));
    }

    // Present Committee
    public function present_committee(Request $request) 
    {
        $committee      = Committee::where('isActive', '=', 1)
                            ->orderBy('id', 'desc')
                            ->first();

        $getMemberList  = Member::join('committees', 'members.committee_id', '=', 'committees.id')
                            ->select(
                                'members.*', 
                                'committees.name as committee_name', 
                                'committees.from as committee_start', 
                                'committees.to as committee_end', 
                                'committees.isActive as committee_is_active'
                            )
                            ->where('isActive', '=', 1)
                            ->where('committee_type', '=', 'Executive')
                            ->orderBy('priority', 'asc')
                            ->get();

        return view('frontend.committee.index', compact(['getMemberList', 'committee']));
    }

    // Committee Advisor
    public function committee_advisor(Request $request) 
    {
        $committee      = Committee::where('isActive', '=', 1)
                            ->orderBy('id', 'desc')
                            ->first();

        $getMemberList  = Member::join('committees', 'members.committee_id', '=', 'committees.id')
                            ->select(
                                'members.*', 
                                'committees.name as committee_name', 
                                'committees.from as committee_start', 
                                'committees.to as committee_end', 
                                'committees.isActive as committee_is_active'
                            )
                            ->where('isActive', '=', 1)
                            ->where('committee_type', '=', 'Advisor')
                            ->orderBy('priority', 'asc')
                            ->get();

        return view('frontend.committee.index', compact(['getMemberList', 'committee']));
    }

    public function previousCommitteesJson()
    {
        // Only inactive committees
        $committees = Committee::where('isActive', 0)
            ->with(['members' => function ($q) {
                $q->select('id', 'committee_id', 'committee_type');
            }])
            ->get();

        $grouped = [];

        foreach ($committees as $committee) {
            foreach ($committee->members as $member) {
                $type = $member->committee_type;

                $fromYear = \Carbon\Carbon::parse($committee->from)->format('Y');
                $toYear = \Carbon\Carbon::parse($committee->to)->format('Y');

                if ($fromYear === $toYear) {
                    $displayYear = $fromYear . '-' . substr($fromYear + 1, 2); // handle same year range
                } else {
                    $displayYear = $fromYear . '-' . substr($toYear, 2);
                }

                $grouped[$type][] = [
                    'id' => $committee->id,
                    'name' => $committee->name,
                    'year_range' => $displayYear,
                    'route' => route('frontend.previous-committee', [
                        'id' => $committee->id,
                        'name' => $member->committee_type, // Executive or Advisor
                    ]),
                ];
            }
        }

        return response()->json($grouped);
    }

    // previous Committee
    public function previous_committee($id, $name)
    {
        // Get the committee by ID
        $committee = Committee::findOrFail($id);

        // Get only members matching the committee AND committee type (Executive or Advisor)
        $getMemberList = Member::join('committees', 'members.committee_id', '=', 'committees.id')
            ->select(
                'members.*',
                'committees.name as committee_name',
                'committees.from as committee_start',
                'committees.to as committee_end',
                'committees.isActive as committee_is_active'
            )
            ->where('committees.id', $id)
            ->where('members.committee_type', $name) // Match Executive or Advisor
            ->orderBy('members.priority', 'asc')
            ->get();

        return view('frontend.committee.index', compact('getMemberList', 'committee'));
    }

    public function addCommittee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'from' => 'required',
            'isActive' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
            $postCommittee = new Committee;
            $postCommittee->name = $request->name;
            $postCommittee->from = $request->from;
            $postCommittee->to = $request->to;
            $postCommittee->isActive = $request->isActive;
            $postCommittee->save();
            return response()->json([
                'status' => 200,
                'success' => 'Add Successfully'
            ]);
        }
    }

    public function editCommittee($id){
        $getdata  = Committee::find($id);
        return response()->json([
           'getdata'=>$getdata,
           'status'=>200
        ]);
    }

    public function updateCommittee(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'from' => 'required',
            'isActive' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
            $postCommittee = Committee::find($id);
            $postCommittee->name = $request->name;
            $postCommittee->from = $request->from;
            $postCommittee->to = $request->to;
            $postCommittee->isActive = $request->isActive;
            $postCommittee->save();
            return response()->json([
                'status' => 200,
                'success' => 'Update Successfully'
            ]);
        }
    }

    public function deleteCommittee($id){
        $getdata = Committee::find($id);
        $getdata->delete();
        return redirect()->back()->with("success", "Delete Successfully");
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
     * @param  \App\Models\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function show(Committee $committee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function edit(Committee $committee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Committee $committee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Committee $committee)
    {
        //
    }
}
