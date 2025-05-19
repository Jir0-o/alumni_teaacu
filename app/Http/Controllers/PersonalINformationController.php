<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use App\Models\Education;
use App\Models\Employment;
use App\Models\Experience;
use App\Models\FamilyMember;
use App\Models\InstituteInfo;
use App\Models\LanguageProficiency;
use App\Models\MemberCategory;
use App\Models\MemberSubcategory;
use App\Models\MemberSubSubcategory;
use App\Models\Person;
use App\Models\RelationType;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserAccomplishment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class PersonalINformationController extends Controller
{
    //  public function index(){
    //     $getProfile = Person::where('user_id', Auth::id())->value('user_id');
    //     $getForProfile = person();
    //     if( $getProfile == Auth::id()){
    //         return redirect(route('home'));
    //     }
    //     else{

    //         $getForProfile = person();
    //         return view('frontend.profile.profile',compact(['getForProfile']));
    //     }

    //  }

    //  public function profileView(){

    //  }

    public function Profile_full_info() {
        $getForProfile = person();
        $getPersonalInformation = Person::find(Auth::id());
        $relationType = RelationType::all();
        $countUser = NewUserCount();
        $getDegrees = Degree::where('person_id',Auth::id())->orderby('year','desc')->get();
        $getExperiences = InstituteInfo::where('person_id',Auth::id())->orderby('form','desc')->get();
        $getEducation = Education::where('person_id',Auth::id())->orderby('passing_year','desc')->get();
        $getAccomplishments = UserAccomplishment::where('user_id',Auth::id())->orderby('id','desc')->get();
        $getSkills = Skill::where('user_id',Auth::id())->orderby('id','desc')->get();
        $getLanguages = LanguageProficiency::where('user_id',Auth::id())->orderby('id','desc')->get();
        $getEmployment = Employment::where('user_id',Auth::id())->orderby('id','desc')->get();

        return view('frontend.profile.profileFullInfo',compact(['getForProfile','getPersonalInformation','relationType','countUser','getDegrees','getExperiences','getEducation','getAccomplishments','getSkills','getLanguages','getEmployment']));
    }

     public function create(Request $request){

        $userId = Auth::id();
        $person = new Person;
        $person->name = $request->name;
        $person->cips_membership_status = $request->cips_membership_status;
        $person->f_name = $request->f_name;
        $person->m_name = $request->m_name;
        $person->present_address = $request->present_address;
        $person->permanent_address = $request->permanent_address;
        $person->dob = $request->dob;
        $person->nid = $request->nid;
        $person->mobile_no = $request->mobile_no;
        $person->alt_mobile_no = $request->alt_mobile_no;
        $person->user_id  = $userId;
        if ($file = $request->file('profileImage')) {
         $imageName = date("dmy") . $file->getClientOriginalName();
         $path = url('/') . "/backend/images/" . $imageName;
         $request->profileImage->move(base_path('/backend/images/'), $imageName);
         $person->profileImage = $path;
         }
        $person->save();
        return redirect(route('home'));
     }
 
    public function view(){
        $getForProfile = person();
        $getPersonalInformation = Person::find(Auth::id());
        $relationType = RelationType::all();
        $countUser = NewUserCount();

        $user = Auth::user();
        $person = Person::where('user_id', $user->id)->first();
        $education = Education::where('person_id', $user->id)->get();
        $employment = Employment::where('user_id', $user->id)->get();

        $menber = MemberCategory::all();
        $serviceCategories = MemberSubcategory::all();
        $serviceSubCategories = MemberSubSubcategory::all();

        $skills = Skill::where('user_id', $user->id)->get();
        $languages = LanguageProficiency::where('user_id', $user->id)->get();
        $accomplishments = UserAccomplishment::where('user_id', $user->id)->get();

        return view('backend.profile.profileView',compact(['getForProfile','getPersonalInformation','relationType','countUser','education','employment','person','user','menber','serviceCategories','serviceSubCategories','skills','languages','accomplishments']));
    }   

    public function ProfileShow(){
    $getForProfile = person();
    $getPersonalInformation = Person::find(Auth::id());
    $relationType = RelationType::all();
    $countUser = NewUserCount();
    $getDegrees = Degree::where('person_id',Auth::id())->orderby('year','desc')->get();
    $getExperiences = InstituteInfo::where('person_id',Auth::id())->orderby('form','desc')->get();
    $getEducation = Education::where('person_id',Auth::id())->orderby('passing_year','desc')->get();
    $getAccomplishments = UserAccomplishment::where('user_id',Auth::id())->orderby('id','desc')->get();
    $getSkills = Skill::where('user_id',Auth::id())->orderby('id','desc')->get();
    $getLanguages = LanguageProficiency::where('user_id',Auth::id())->orderby('id','desc')->get();
    $getEmployment = Employment::where('user_id',Auth::id())->orderby('id','desc')->get();

    return view('backend.profile.index',compact(['getForProfile','getPersonalInformation','relationType','countUser','getDegrees','getExperiences','getEducation','getAccomplishments','getSkills','getLanguages','getEmployment']));
    }

     //profile Update

     public function update(Request $request){
        if($request->number_of_child<0){
            return response()->json([
                'status' => 400,
                'error'=>'Number Of Child Section Must Be Positive',
            ]);
        }
        $person = Person::find(Auth::id());
        $person->name = $request->name;
        $person->cips_membership_status = $request->cips_membership_status;
        $person->f_name = $request->f_name;
        $person->m_name = $request->m_name;
        $person->present_address = $request->present_address;
        $person->permanent_address = $request->permanent_address;
        $person->dob = $request->dob;
        $person->nid = $request->nid;
        $person->mobile_no = $request->mobile_no;
        $person->alt_mobile_no = $request->alt_mobile_no;
        $person->spouse = $request->spouse;
        $person->number_of_child = $request->number_of_child;

        if ($file = $request->file('profileImage')) {
         $imageName = date("dmy") . $file->getClientOriginalName();
         $path = url('/') . "/backend/images/" . $imageName;
         $request->profileImage->move(base_path('/backend/images/'), $imageName);
         $person->profileImage = $path;
         }
        $person->save();

        if($request->password){
            $current_password = $request->password;
            $user =  Auth::user();
            if(Hash::check($current_password,$user->password)){
                if($request->new_password==$request->new_password_confirmation){
                    $newPassword = Hash::make($request->new_password);
                    $user->password =$newPassword ;
                    $user->save();
                }
                else{
                    return response()->json([
                        'error'=>'Your New Password And Confirmation Password Are Not The Same'
                    ]);
                }
            }
            else{
                return response()->json([
                    'error'=>'Your Old Password Is Not Correct'
                ]);
            }
        }


        return response()->json([
            'status'=>200,
            'success'=>'Profile Update Successfully',
        ]);
     }

     public function add_experiences(Request $request){
        $validator = Validator::make($request->all(), [
            'institute_name' => 'required',
            'position' => 'required',
            'joined_year' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postExperiences =new Experience;
        $postExperiences->institute_name = $request->institute_name;
        $postExperiences->position = $request->position;
        $postExperiences->joined_year = $request->joined_year;
        $postExperiences->retirement_year = $request->retirement_year;
        $postExperiences->person_id = $request->person_id;
        $postExperiences->save();
        return response()->json([
            'status'=>200,
            'success'=>'Add Successfully'
        ]);
       }
     }

     public function get_experiences($id){
        $getExperiences = Experience::where('person_id',$id)->get();
        if($getExperiences){
            return response()->json([
                'getExperiences'=>$getExperiences
            ]);
        }
        else{
            return response()->json([
                'getExperiences'=>NULL
            ]);
        }
     }
     //update Experiences
     public function update_experiences(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'institute_name' => 'required',
            'position' => 'required',
            'joined_year' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postExperiences =Experience::find($id);
        $postExperiences->institute_name = $request->institute_name;
        $postExperiences->position = $request->position;
        $postExperiences->joined_year = $request->joined_year;
        $postExperiences->retirement_year = $request->retirement_year;
        $postExperiences->person_id = $request->person_id;
        $postExperiences->save();
        return response()->json([
            'status'=>200,
            'success'=>'Update Successfully'
        ]);
       }
     }

     //delete Experiences

     public function delete_experiences($id){
        $postExperiences =Experience::find($id);
        $postExperiences->delete();
        return response()->json([
            'status'=>200,
            'delete'=>'Delete Successfully'
        ]);
     }


     //Add Working Experiences
     public function add_working_experiences(Request $request){
        $validator = Validator::make($request->all(), [
            'organization' => 'required',
            'designation' => 'required',
            'form' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postExperiences =new InstituteInfo;
        $postExperiences->organization = $request->organization;
        $postExperiences->designation = $request->designation;
        $postExperiences->address = $request->address;
        $postExperiences->form = $request->form;
        $postExperiences->to = $request->to;
        $postExperiences->person_id = $request->person_id;
        $postExperiences->save();
        return response()->json([
            'status'=>200,
            'success'=>'Add Successfully'
        ]);
       }
     }

     //Get Working Experiences

     public function get_working_experiences($id){
        $getExperiences = InstituteInfo::where('person_id',$id)->orderby('form','desc')->get();
        if($getExperiences){
            return response()->json([
                'getExperiences'=>$getExperiences
            ]);
        }
        else{
            return response()->json([
                'getExperiences'=>NULL
            ]);
        }
     }

     //Update Working Experience

     public function update_working_experiences(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'organization' => 'required',
            'designation' => 'required',
            'form' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postExperiences =InstituteInfo::find($id);
        $postExperiences->organization = $request->organization;
        $postExperiences->designation = $request->designation;
        $postExperiences->address = $request->address;
        $postExperiences->form = $request->form;
        $postExperiences->to = $request->to;
        $postExperiences->person_id = $request->person_id;
        $postExperiences->save();
        return response()->json([
            'status'=>200,
            'success'=>'Update Successfully'
        ]);
       }
     }

     //Delete Working Experiences


     public function delete_working_experiences($id){
        $postExperiences =InstituteInfo::find($id);
        $postExperiences->delete();
        return response()->json([
            'status'=>200,
            'delete'=>'Delete Successfully'
        ]);
     }

     //add family

     public function add_family(Request $request){
        $validator = Validator::make($request->all(), [
            'spouse' => 'required',
            'number_of_child' => 'required',
            // 'dob' => 'required',
            // 'is_cips_member' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postFamilyMember = FamilyMember::where('id',1)->get()->first();
        $postFamilyMember->spouse = $request->spouse;
        $postFamilyMember->person_id  = $request->person_id ;
        // $postFamilyMember->relation_type_id  = $request->relation_type_id ;
        // $postFamilyMember->dob = $request->dob;
        // $postFamilyMember->is_cips_member = $request->is_cips_member;
        $postFamilyMember->number_of_child = $request->number_of_child;
        $postFamilyMember->save();
        return response()->json([
            'status'=>200,
            'success'=>'Add Successfully'
        ]);
        }
     }

     //get Family

     public function get_family($id){
        $getFamily = FamilyMember::where('family_members.person_id',$id)->orderby('id','desc')->get();
        if($getFamily){
            return response()->json([
                'getFamily'=>$getFamily
            ]);
        }
        else{
            return response()->json([
                'getFamily'=>NULL
            ]);
        }
     }

     //get Relation Type Data

     public function get_relation_type(){
        $getRealtionTypeData = RelationType::all();
        return response()->json([
            'status'=>200,
            'getRealtionTypeData'=>$getRealtionTypeData
        ]);
     }

     //update Family Member
     public function update_family(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'spouse' => 'required',
            'number_of_child' => 'required',
            // 'dob' => 'required',
            // 'is_cips_member' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postFamilyMember = FamilyMember::find($id);
        $postFamilyMember->spouse = $request->spouse;
        $postFamilyMember->person_id  = $request->person_id ;
        // $postFamilyMember->relation_type_id  = $request->relation_type_id ;
        // $postFamilyMember->dob = $request->dob;
        // $postFamilyMember->is_cips_member = $request->is_cips_member;
        $postFamilyMember->number_of_child = $request->number_of_child;
        $postFamilyMember->save();
        return response()->json([
            'status'=>200,
            'success'=>'Update Successfully'
        ]);
      }
     }

     //Delete Family Member

     public function delete_family($id){
        $postFamily =FamilyMember::find($id);
        $postFamily->delete();
        return response()->json([
            'status'=>200,
            'delete'=>'Delete Successfully'
        ]);
     }

     //add education

     public function add_education(Request $request){
        $validator = Validator::make($request->all(), [
            'passing_year' => 'required',
            // 'result' => 'required',
            'education_level' => 'required',
            'education_institute' => 'required',
            'education_board_universities' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postEducation = new Education;
        $postEducation->passing_year = $request->passing_year;
        $postEducation->result = $request->result;
        $postEducation->person_id  = $request->person_id ;
        $postEducation->education_level = $request->education_level;
        $postEducation->education_institute = $request->education_institute;
        $postEducation->education_board_universities = $request->education_board_universities;
        $postEducation->save();
        return response()->json([
            'status'=>200,
            'success'=>'Add Successfully'
        ]);
        }
     }


     public function get_education($id){
        $getEducation = Education::where('person_id',$id)->orderby('passing_year','desc')->get();

       if($getEducation){
            return response()->json([
                'getEducation'=>$getEducation
            ]);
        }
        else{
            return response()->json([
                'getEducation'=>NULL
            ]);
        }
     }

     //Update Education
     public function update_education(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'passing_year' => 'required',
            // 'result' => 'required',
            'education_level' => 'required',
            'education_institute' => 'required',
            'education_board_universities' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill The Required Section'
            ]);
        } else {
        $postEducation = Education::find($id);
        $postEducation->passing_year = $request->passing_year;
        $postEducation->result = $request->result;
        $postEducation->person_id  = $request->person_id ;
        $postEducation->education_level = $request->education_level;
        $postEducation->education_institute = $request->education_institute;
        $postEducation->education_board_universities = $request->education_board_universities;
        $postEducation->save();
        return response()->json([
            'status'=>200,
            'success'=>'Update Successfully'
        ]);
      }
     }

     //Delete Education


     public function delete_education($id){
        $postFamily =Education::find($id);
        $postFamily->delete();
        return response()->json([
            'status'=>200,
            'delete'=>'Delete Successfully'
        ]);
     }

    public function getSubCategories($id)
    {
        $subCategories = MemberSubSubCategory::where('member_subcategory_id', $id)->get(['id', 'name']);
        return response()->json($subCategories);
    }

    public function sendRequest()
    {
        $user = Auth::user();

        $person = Person::where('user_id', $user->id)->first();

        if ($person) {
            $person->update([
                'status' => 5,
            ]);
        }

        $user = User::find($user->id);
        $user->update([
            'status' => 5,
        ]);

        return back()->with('success', 'Request Sent Successfully');
    }

    public function approveRequest($id)
    {
        $user = User::find($id);

        $user->update([
            'status' => 1,
            'role' => auth()->user()->hasRole('Admin') ? 1 : 0,
        ]);

        $person = Person::where('user_id', $user->id)->first();
        if ($person) {
            $person->update([
                'status' => 1,
            ]);
        }
        return back()->with('success', 'User Request Approved Successfully');
    }

        public function rejectRequest($id)
    {
        $user = User::find($id);
        $user->update([
            'status' => 2,
        ]);
        $person = Person::where('user_id', $user->id)->first();
        if ($person) {
            $person->update([
                'status' => 2,
            ]);
        }
        return back()->with('success', 'User Request Rejected Successfully');
    }

}
