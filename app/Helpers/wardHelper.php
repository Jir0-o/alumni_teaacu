<?php

use App\Models\Family;
use App\Models\Person;
use App\Models\User;
use App\Models\EventGallery;
use App\Models\EventPic;
use App\Models\Notice;
use App\Models\FamilyMember;
use App\Models\EducationBoardUniversity;
use App\Models\EducationLevel;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Degree;
use App\Models\EducationInstitute;
use App\Models\InstituteInfo;
use App\Models\ShowcaseAbout;
use Illuminate\Support\Facades\Auth;

function person(){
    $getForProfile = Person::find(Auth::id());
    if($getForProfile){
        return $getForProfile;
    }
    else{
        return  $getForProfile = NULL;
    }

}
function getAbout()
{
    $about = ShowcaseAbout::where('isActive',1)->orderby('id','DESC')->first();
    return $about;
}
function getAbouts()
{
    $about = ShowcaseAbout::orderby('id','DESC')->get();
    return $about;
}

function EventAlongWithPicture(){
    $events = EventGallery::leftJoin('people','event_galleries.created_by','=','people.id')
    ->select('people.name','people.id','event_galleries.*')->where('event_galleries.isActive', 1)->orderby('event_galleries.id','DESC')->simplePaginate(5);

    return $events;
}
function SearchByName($name){
    $persons = Person::leftJoin('users','people.user_id','=','users.id')
    ->where('people.name', 'LIKE', '%'.$name.'%')->get();
    return $persons;
}
function SearchByCIPS($CIPS){
    $persons = Person::leftJoin('users','people.user_id','=','users.id')
    ->where('users.cips', 'LIKE', '%'.$CIPS.'%')->get();
    return $persons;
}
function SearchByBoth($cips,$name){
    $persons = Person::leftJoin('users','people.user_id','=','users.id')
    ->where('people.name', 'LIKE', '%'.$name.'%')->orWhere('users.cips','LIKE','%'.$cips.'%')->get();
    return $persons;
}
function viewById($id){
    $person = Person::leftJoin('users','people.user_id','=','users.id')
    ->where('people.id',$id)->first();
    return $person;
}
function ExperienceById($id){
    $experience = InstituteInfo::where('person_id',$id)->orderby('form','DESC')->get();
    return $experience;
}
function EducationById($id){
    $education = Education::where('person_id',$id)->orderby('passing_year','DESC')->get();
    return $education;
}
function EducationLevel(){
    $level = EducationLevel::get();
    return $level;
}
function FamilyMemberById($id){
    $family = FamilyMember::leftJoin('relation_types','family_members.relation_type_id','=','relation_types.id')->where('person_id',$id)->get();
    return $family;
}

function NewEvent()
{
    $event = EventGallery::leftJoin('people','event_galleries.created_by','=','people.id')
    ->where('event_galleries.isActive',0)->select('event_galleries.id','people.name','event_galleries.title','event_galleries.created_by')->orderby('event_galleries.id','DESC')->get();
    return $event;
}
function AllEventShow()
{
    $event = EventGallery::leftJoin('people','event_galleries.created_by','=','people.id')
    ->select('event_galleries.id','people.name','event_galleries.title','event_galleries.created_by','event_galleries.isActive')->where('event_galleries.isActive',1)->orwhere('event_galleries.isActive',2)->orderby('event_galleries.id','DESC')->simplepaginate(25);
    return $event;
}
function NewNotice()
{
    $notice = Notice::leftJoin('people','notices.person_id','=','people.id')
    ->where('notices.isActive',0)->select('notices.id','people.name','notices.title','notices.person_id')->orderby('notices.id','DESC')->get();
    return $notice;
}
function AllNoticeShow()
{
    $notice = Notice::leftJoin('people','notices.person_id','=','people.id')
    ->select('notices.id','people.name','notices.title','notices.person_id','notices.isActive')->where('notices.isActive',1)->orwhere('notices.isActive',2)->orderby('notices.id','DESC')->get();
    return $notice;
}

function newUsers(){
    $users = User::where('role', 0)->orderby('id','DESC')->get();
    return $users;
}
function NewUserCount(){
    $users = User::where('role', 0)->count();
    return $users;
}
function RegisteredUsers(){
    $users = User::where('role', 2)->orwhere('role', 1)->orderby('id','DESC')->get();
    return $users;
}
function RegistereUserCount(){
    $users = User::where('role', 2)->count();
    return $users;
}
function totalEvent(){
    $event = EventGallery::count();
    return $event;
}

function totalNotice(){
    $event = Notice::count();
    return $event;
}

function totalUser(){
    $event = User::count();
    return $event;
}
function Degree($id)
{
    $degree = Degree::where('person_id',$id)->orderby('year','DESC')->get();
    return $degree;
}

// function searchMember(){
//     $persons = Person::leftJoin('users','people.user_id','=','users.id')->
//     leftJoin('institute_infos','people.id','=','institute_infos.person_id')
//     ->where('people.name', 'LIKE', '%'.$name.'%')->orWhere('users.cips','LIKE','%'.$cips.'%')->orWhere('institute_infos.designation','LIKE','%'.$designation.'%')->orWhere('institute_infos.organization','LIKE','%'.$organization.'%')->orWhere('institute_infos.address','LIKE','%'.$location.'%')->orderby('institute_infos.form','DESC')->first();
//     return $persons;
// }