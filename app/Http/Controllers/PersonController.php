<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\EducationBoardUniversity;
use App\Models\EducationInstitute;
use App\Models\EducationLevel;
use App\Models\Experience;
use App\Models\Family;
use App\Models\Holding;
use App\Models\Moholla;
use App\Models\Person;
use App\Models\SpecialAllowance;
use App\Models\SpecialAllowanceInformatio;
use App\Models\Village;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getdata = Person::join('families', 'families.id', '=', 'people.families_id')
            ->join('holdings', 'holdings.id', '=', 'families.hold_id')
            ->join('mohollas', 'mohollas.id', '=', 'holdings.moholla_id')
            ->join('villages', 'villages.id', '=', 'mohollas.village_id')
            ->join('wards', 'wards.id', '=', 'villages.ward_id')
            ->select('people.*', 'families.fam_name', 'holdings.hold_name', 'mohollas.moholla_name', 'villages.village_name', 'wards.ward_name')
            ->get();
        return view('backend.person.personList', compact(['getdata']));
    }

    public function person_view($id)
    {
        
        $getdata = Person::find(decrypt($id));
        $getfamilydata = Family::find($getdata->families_id);
        // $geteducation = Education::where('education.person_id',$getdata->id)->get()->first();
        // $getEducationLevel = EducationLevel::where('education_levels.id',$geteducation->education_level_id)->get()->first();
        // $getEducationInstitute = EducationInstitute::where('education_institutes.id',$geteducation->education_institute_id)->get()->first();
        // $getEducationBoardUniversity = EducationBoardUniversity::where('education_board_universities.id',$geteducation->education_board_universities_id)->get()->first();
        // $getExperiences = Experience::where('experiences.person_id',$getdata->id)->get()->first();
        // $getSecialAllowance = SpecialAllowanceInformatio::where('special_allowance_informatios.person_id',$getdata->id)->get()->first();
        $getHolding = Holding::where('id', $getfamilydata->hold_id)->get()->first();
        $getMoholla = Moholla::where('id', $getHolding->moholla_id)->get()->first();
        $getVillage = Village::where('id', $getMoholla->village_id)->get()->first();
        $getWard = Ward::where('id', $getVillage->ward_id)->get()->first();
        $getFullEducationLevel = EducationLevel::all();
        $addFullEducationLevel = EducationLevel::all();
        $getFullEducationInstitute = EducationInstitute::all();
        $addFullEducationInstitute = EducationInstitute::all();
        $getFullEducationBoardUniversity = EducationBoardUniversity::all();
        $addFullEducationBoardUniversity = EducationBoardUniversity::all();

        return view('backend.person.personView', compact(
            [
                'getdata',
                'getfamilydata',
                // 'geteducation',
                // 'getEducationLevel',
                // 'getEducationInstitute',
                // 'getEducationBoardUniversity',
                // 'getExperiences',
                // 'getSecialAllowance',
                'getHolding',
                'getMoholla',
                'getVillage',
                'getWard',
                'getFullEducationLevel',
                'getFullEducationInstitute',
                'getFullEducationBoardUniversity',
                'addFullEducationInstitute',
                'addFullEducationLevel',
                'addFullEducationBoardUniversity'
            ]
        ));
    }

    public function person_view_get_ajax($id, Request $request)
    {
        if ($request->ajax()) {
            $neweducation = Education::join('education_levels', 'education_levels.id', '=', 'education.education_level_id')
                ->join('education_institutes', 'education_institutes.id', '=', 'education.education_institute_id')
                ->join('education_board_universities', 'education_board_universities.id', '=', 'education.education_board_universities_id')
                ->where('education.person_id', $id)
                ->select(
                    'education.passing_year',
                    'education.result',
                    'education.id',
                    'education.education_level_id',
                    'education.education_institute_id',
                    'education.education_board_universities_id',
                    'education.person_id',
                    'education_levels.level_name',
                    'education_institutes.institute_name',
                    'education_board_universities.board_university_name'
                )
                ->get();
            if ($neweducation == NULL) {
                return response()->json([
                    'status' => false
                ]);
            }
            return response()->json([
                'neweducation' => $neweducation,
            ]);
        }
    }

    public function person_view_get_ajax_education_level($id, Request $request)
    {
        if ($request->ajax()) {
            $getAlleducation_levels = EducationLevel::all(); 
            $getAlleducation_institutes = EducationInstitute::all();
            $getAlleducation_board_universities = EducationBoardUniversity::all();
            return response()->json([
                'status' => 200,
                'getAlleducation_levels' => $getAlleducation_levels,
                'getAlleducation_institutes' => $getAlleducation_institutes,
                'getAlleducation_board_universities' => $getAlleducation_board_universities,
            ]);
        }
    }

    public function person_view_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'f_name' => 'required',
            'm_name' => 'required',
            'dob' => 'required',
            'mobile_no' => 'required',

        ], [
            'name.required' => 'This field is required.',
            'f_name.required' => 'This field is required.',
            'm_name.required' => 'This field is required.',
            'dob.required' => 'This field is required.',
            'mobile_no.required' => 'This field is required.',
        ]);
        $person =  Person::find($id);
        $person->name = $request->name;
        $person->alias_name = $request->alias_name;
        $person->f_name = $request->f_name;
        $person->m_name = $request->m_name;
        $person->spouse_name = $request->spouse_name;
        $person->dob = $request->dob;
        $person->b_c_no = $request->b_c_no;
        $person->nid = $request->nid;
        $person->mobile_no = $request->mobile_no;
        $person->alt_mobile_no = $request->alt_mobile_no;
        $person->email = $request->email;
        $person->present_address = $request->present_address;
        $person->permanent_address = $request->permanent_address;
        $person->save($validatedData);

        return redirect()->back()->with('success', 'Person Details Update SuccessFull');
    }

    public function person_view_education_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'passing_year' => 'required',
            'result' => 'required',
            'education_level_id' => 'required',
            'education_institute_id' => 'required',
            'education_board_universities_id' => 'required',

        ], [
            'passing_year.required' => 'This field is required.',
            'result.required' => 'This field is required.',
            'education_level_id.required' => 'This field is required.',
            'education_institute_id.required' => 'This field is required.',
            'education_board_universities_id.required' => 'This field is required.',
        ]);
        $getdata = Education::find($id);
        $getdata->passing_year = $request->passing_year;
        $getdata->result = $request->result;
        $getdata->education_level_id = $request->education_level_id;
        $getdata->education_institute_id = $request->education_institute_id;
        $getdata->education_board_universities_id = $request->education_board_universities_id;
        $getdata->save($validatedData);
        return redirect()->back()->with('updateEducation', 'Education Details Update SuccessFull');
    }


    public function person_view_profession_update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'institute_name' => 'required',
            'position' => 'required',
            'joined_year' => 'required',
            'retirement_year' => 'required',

        ], [
            'institute_name.required' => 'This field is required.',
            'position.required' => 'This field is required.',
            'joined_year.required' => 'This field is required.',
            'retirement_year.required' => 'This field is required.',
        ]);

        $getdata = Experience::find($id);
        $getdata->institute_name = $request->institute_name;
        $getdata->position = $request->position;
        $getdata->joined_year = $request->joined_year;
        $getdata->retirement_year = $request->retirement_year;
        $getdata->save($validatedData);
        return redirect()->back()->with('updateExperience', 'Professional Information Update SuccessFull');
    }

    public function person_view_specialAllowance_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'allowance_name' => 'required',
            'frequency' => 'required',
            'amount' => 'required',
        ], [
            'allowance_name.required' => 'This field is required.',
            'frequency.required' => 'This field is required.',
            'amount.required' => 'This field is required.',
        ]);

        $getdata = SpecialAllowanceInformatio::find($id);
        $getdata->allowance_name = $request->allowance_name;
        $getdata->frequency = $request->frequency;
        $getdata->amount = $request->amount;
        $getdata->save($validatedData);
        return redirect()->back()->with('updateSpecialAllowanceInformatio', 'Special Allowance Information Update SuccessFull');
    }


    public function person_view_education_add(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'passing_year_add' => 'required',
            'result_add' => 'required',
            'education_level_id_add' => 'required',
            'education_institute_id_add' => 'required',
            'education_board_universities_id_add' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill All Section'
            ]);
        }

        $postData = new Education;
        $postData->person_id = $request->Id_get_data;
        $postData->passing_year = $request->passing_year_add;
        $postData->result = $request->result_add;
        $postData->education_level_id = $request->education_level_id_add;
        $postData->education_institute_id  = $request->education_institute_id_add;
        $postData->education_board_universities_id  = $request->education_board_universities_id_add;
        $postData->save();
        return response()->json([
            'status' => 200,
            'success' => 'Education Information Add SuccessFull',

        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person = new Person();
        $person->name = $request->name;
        $person->alias_name = $request->alias_name;
        $person->f_name = $request->f_name;
        $person->m_name = $request->m_name;
        $person->spouse_name = $request->spouse_name;
        $person->dob = $request->dob;
        $person->b_c_no = $request->b_c_no;
        $person->nid = $request->nid;
        $person->mobile_no = $request->mobile_no;
        $person->alt_mobile_no = $request->alt_mobile_no;
        $person->email = $request->email;
        $person->dod = $request->dod;
        $person->present_address = $request->present_address;
        $person->permanent_address = $request->permanent_address;
        $person->families_id = $request->families_id;
        $person->save();
        // Save Educational Institute
        if ($request->education_institute_id != null) {
            for ($i = 0; $i < sizeof($request->education_institute_id); $i++) {
                $education = new Education();
                $education->person_id = $person->id;
                $education->education_institute_id = $request->education_institute_id[$i];
                $education->education_level_id = $request->education_level_id[$i];
                $education->education_board_universities_id = $request->education_board_universities_id[$i];
                $education->passing_year = $request->passing_year[$i];
                $education->result = $request->result[$i];
                $education->save();
            }
        }
        if ($request->company_name != null) {
            // Save Professional Institute
            for ($j = 0; $j < sizeof($request->company_name); $j++) {
                $experience = new Experience();
                $experience->person_id = $person->id;
                $experience->institute_name = $request->company_name[$j];
                $experience->position = $request->position[$j];
                $experience->joined_year = $request->joined_year[$j];
                $experience->retirement_year = $request->retirement_year[$j];
                $experience->save();
            }
        }
        if ($request->special_allowance != null) {
            // Save Special Allowances
            for ($k = 0; $k < sizeof($request->special_allowance); $k++) {
                $data = SpecialAllowance::find($request->special_allowance[$k]);
                $Allowances = new SpecialAllowanceInformatio();
                $Allowances->person_id = $person->id;
                $Allowances->allowance_name = $data->name;
                $Allowances->frequency = $data->frequency;
                $Allowances->amount = $data->amount;
                $Allowances->save();
            }
        }
        return redirect()->back()->with("success", "Congratulations !! Person Created Successfully!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetAllowance()
    {
        $allowance = SpecialAllowance::all();

        return response()->json($allowance);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}
