<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\EducationBoardUniversityController;
use App\Http\Controllers\EducationInstituteController;
use App\Http\Controllers\EducationLevelController;
use App\Http\Controllers\EventGalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InstituteInfoController;
use App\Http\Controllers\LeadershipMessageController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PersonalINformationController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PersonViewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShowcaseAboutController;
use App\Http\Controllers\UserController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberDirectoryController;
use App\Http\Controllers\PopupNoticeController;
use App\Http\Controllers\PublicationController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::prefix('/frontend')->name('frontend.')->group(function () {
    Route::get('about', [HomeController::class, 'show'])->name('about');
    Route::get('member', [HomeController::class, 'member'])->name('member');
    Route::get('/member/filter/{id}/{category_name}', [HomeController::class, 'filterMembers'])->name('member.filter');
    Route::get('filter-member',[MemberController::class, 'filter'])->name('filter.member');
    Route::get('profile/view/{id}', [MemberController::class, 'viewPerson'])->name('viewProfile');
    Route::get('notice', [NoticeController::class, 'notice'])->name('notice');
    Route::get('event',[EventGalleryController::class,'index'])->name('event');
    Route::get('committee_details/{id}',[HomePageController::class, 'commmitteeDetails'])->name('committeeDetails');
    Route::get('present-committee', [CommitteeController::class, 'present_committee'])->name('present.committee');
    Route::get('committee/advisor', [CommitteeController::class, 'committee_advisor'])->name('committee.advisor');
    Route::get('previous-committee/{id}/{name}', [CommitteeController::class, 'previous_committee'])->name('previous-committee');
    Route::get('/previous-committees', [CommitteeController::class, 'previousCommitteesJson'])->name('previous.committees.json');
    Route::get('/member-directory', [MemberDirectoryController::class, 'index'])->name('member.directory');

    Route::get('/publication',[PublicationController::class, 'index'])->name('publication');

    Route::get('publication',[PublicationController::class, 'index'])->name('publication');
    Route::get('/api/dashboard-counts', function () {
        return response()->json([
            'members' => \App\Models\User::where('status', 3)->count(),
            'notices' => \App\Models\Notice::where('isActive', 1)->count(),
            'events'  => \App\Models\EventGallery::where('isActive', 1)->count(),
        ]);
    })->name('home.counts');
    Route::resource('about', AboutController::class)->only(['store', 'update']);
});
 
// Members route area
Route::middleware('member')->group(function () {
    //Profile
    Route::get('/profile-view', [PersonalINformationController::class, 'view'])->name('profile.view');
    Route::get('/profile-request', [PersonalINformationController::class, 'sendRequest'])->name('profile.request');
    Route::post('/profile-update', [PersonalINformationController::class, 'update'])->name('profile.update');
    Route::post('/add-experiences', [PersonalINformationController::class, 'add_experiences'])->name('add.experiences');
    Route::get('/get-experiences/{id}', [PersonalINformationController::class, 'get_experiences'])->name('get.experiences');
    Route::put('/update-experiences/{id}', [PersonalINformationController::class, 'update_experiences'])->name('update.experiences');
    Route::get('/delete-experiences/{id}', [PersonalINformationController::class, 'delete_experiences'])->name('delete.experiences');
    Route::get('/profile-show', [PersonalINformationController::class, 'ProfileShow'])->name('Profile.Show');
    Route::get('/full_info', [PersonalINformationController::class, 'Profile_full_info'])->name('profile.full_info');
    Route::get('/get-sub-categories/{id}', [PersonalINformationController::class, 'getSubCategories'])->name('get.subcategories');


    //Working Experiences
    Route::post('/add-working-experiences', [PersonalINformationController::class, 'add_working_experiences'])->name('add.WorkingExperiences');
    Route::get('/get-working-experiences/{id}', [PersonalINformationController::class, 'get_working_experiences'])->name('get.WorkingExperiences');
    Route::put('/update-working-experiences/{id}', [PersonalINformationController::class, 'update_working_experiences'])->name('update.WorkingExperiences');
    Route::get('/delete-working-experiences/{id}', [PersonalINformationController::class, 'delete_working_experiences'])->name('delete.WorkingExperiences');
    //Family
    Route::post('/add-family', [PersonalINformationController::class, 'add_family'])->name('add.family');
    Route::get('/get-family/{id}', [PersonalINformationController::class, 'get_family'])->name('get.family');
    Route::get('/get-relation-type', [PersonalINformationController::class, 'get_relation_type'])->name('get.relationType');
    Route::put('/update-family/{id}', [PersonalINformationController::class, 'update_family'])->name('update.family');
    Route::get('/delete-family/{id}', [PersonalINformationController::class, 'delete_family'])->name('delete.family');

    Route::view('/user_profile', 'backend.profile.userProfile')->name('profile.userProfile');

    Route::post('/add-education', [PersonalINformationController::class, 'add_education'])->name('add.education');
    Route::get('/get-education/{id}', [PersonalINformationController::class, 'get_education'])->name('get.education');
    Route::put('/update-education/{id}', [PersonalINformationController::class, 'update_education'])->name('update.education');
    Route::get('/delete-education/{id}', [PersonalINformationController::class, 'delete_education'])->name('delete.education');

    //Degrees
    Route::post('/add-degrees', [DegreeController::class, 'add_degress'])->name('add.degrees');
    Route::get('/get-degrees/{id}', [DegreeController::class, 'get_degrees'])->name('get.degrees');
    Route::put('/update-degrees/{id}', [DegreeController::class, 'update_degrees'])->name('update.degrees');
    Route::get('/delete-degress/{id}', [DegreeController::class, 'delete_degrees'])->name('delete.degrees');
    //Person
    Route::view('/create_person', 'backend.person.create')->name('person.create');
    Route::post('/store_person', [PersonController::class, 'store'])->name('person.store');

    //Educational InsTitute
    Route::get('/ajax-get-institutes', [EducationInstituteController::class, 'ajaxGetInstitute'])->name('ajaxGetInstitute');
    Route::get('/ajax-store-institute/{institute_name}', [EducationInstituteController::class, 'ajaxStoreInstitute'])->name('ajaxStoreInstitute');

    //Education Level
    Route::get('/ajax-get-edu-level', [EducationLevelController::class, 'ajaxGetEduLevel'])->name('ajaxGetEduLevel');
    Route::get('/ajax-store-edu-level/{level_name}', [EducationLevelController::class, 'ajaxStoreEduLevel'])->name('ajaxStoreEduLevel');

    //Board or University
    Route::get('/ajax-get-board', [EducationBoardUniversityController::class, 'ajaxGetBoard'])->name('ajaxGetBoard');
    Route::get('/ajax-store-board/{board_university_name}', [EducationBoardUniversityController::class, 'ajaxStoreBoard'])->name('ajaxStoreBoard');

    // Institute or Company
    Route::get('/ajax-get-company', [InstituteInfoController::class, 'ajaxGetInstitute'])->name('ajaxGetInstitute');
    Route::post('/ajax-store-company', [InstituteInfoController::class, 'ajaxStoreInstitute'])->name('ajaxStoreInstitute');

    // Institute or Company type
    Route::get('/ajax-get-company-type', [InstituteInfoController::class, 'ajaxGetInstituteType'])->name('ajaxGetInstituteType');

    //Person
    Route::view('/create_person', 'backend.person.create')->name('person.create');
    Route::get('/person-list', [PersonController::class, 'index'])->name('personList');
    Route::get('/person-view/{id}', [PersonController::class, 'person_view'])->name('personView');
    Route::get('/person-view/getajax/{id}', [PersonController::class, 'person_view_get_ajax'])->name('personViewAjax');
    Route::get('/person-view/getEducationLevel/{id}', [PersonController::class, 'person_view_get_ajax_education_level'])->name('personViewAjaxEducationLevel');
    Route::post('/store_person', [PersonController::class, 'store'])->name('person.store');
    Route::put('person-view-update/{id}', [PersonController::class, 'person_view_update'])->name('personViewUpdate');
    Route::put('person-view-education-update/{id}', [PersonController::class, 'person_view_education_update'])->name('personViewEducationUpdate');
    Route::put('person-view-profession-update/{id}', [PersonController::class, 'person_view_profession_update'])->name('personViewProfessionUpdate');
    Route::put('person-view-specialAllowance-update/{id}', [PersonController::class, 'person_view_specialAllowance_update'])->name('personViewSpecialAllowanceUpdate');
    Route::POST('person-view/person-view-education-add/{id}', [PersonController::class, 'person_view_education_add'])->name('personViewEducationAdd');
    Route::put('person-view/person-education-update/{id}/{education_id}', [PersonViewController::class, 'person_education_update'])->name('personViewEducationUpdate');
    Route::POST('person-view/profession-information-add/{id}', [PersonViewController::class, 'profession_information_add'])->name('personViewInformationAdd');
    Route::get('person-view/profession-information-get/{id}', [PersonViewController::class, 'profession_information_get'])->name('personViewInformationGet');
    Route::put('person-view/profession-information-update/{id}/{professional_information_id}', [PersonViewController::class, 'profession_information_update'])->name('personViewInformationUpdate');
    Route::POST('person-view/special-allowance-add/{id}', [PersonViewController::class, 'special_allowance_add'])->name('personSpecialAllowanceAdd');
    Route::get('person-view/special-allowance-get/{id}', [PersonViewController::class, 'special_allowance_get'])->name('personSpecialAllowanceGet');
    Route::put('person-view/special-allowance-update/{id}/{special_allowance_information}', [PersonViewController::class, 'special_allowance_update'])->name('personSpecialAllowanceUpdate');

    //Family Member
    // Route::get('/create_family', [FamilyController::class, 'index'])->name('family.create');
    // Route::get('/getHold/{id}', [FamilyController::class, 'holding']);
    // Route::post('createFamily', [FamilyController::class, 'create'])->name('family.creates');
    // Route::get('/family', [FamilyController::class, 'view'])->name('family.view');
    // Route::get('/family/edit/{id}', [FamilyController::class, 'edit'])->name('family.edit');
    // Route::post('/family_update/{id}', [FamilyController::class, 'SaveUpdate'])->name('family.SaveUpdate');
    // Route::get('/getFamily/{id}', [FamilyController::class, 'getFamily'])->name('getFamilies');

    // Settings
    Route::get('/settings/index', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/view', [SettingsController::class, 'view'])->name('settings.view');
    Route::get('/settings/settingsView', [SettingsController::class, 'settingsView'])->name('settings.settingsView');
    Route::get('/settings/update/{id}', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/create', [SettingsController::class, 'create'])->name('settings.create');
    Route::get('/settings/update/{id}', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('settings_update/{id}', [SettingsController::class, 'SaveUpdate'])->name('settings.SaveUpdate');

    // Notice
    Route::post('/create-notice', [NoticeController::class, 'store'])->name('createNotice');
    Route::get('/my-Notice', [NoticeController::class, 'MyNotice'])->name('MyNotice');
    Route::get('/my-Notice/action/{id}', [NoticeController::class, 'MyNoticeAction'])->name('MyNoticeAction');
    Route::POST('/my-Notice/Update/{id}', [NoticeController::class, 'updateNotice'])->name('updateNotice');

    //Event
    Route::Post('/create-event', [EventGalleryController::class, 'store'])->name('createEvent');
    Route::Post('/event-register', [EventGalleryController::class, 'eventRegister'])->name('eventRegister');
    Route::get('/my-event', [EventGalleryController::class, 'MyEvent'])->name('MyEvent');
    Route::get('/my-event/{id}', [EventGalleryController::class, 'deleteEvent'])->name('event.delete');
    Route::get('/my-event/action/{id}', [EventGalleryController::class, 'MyEventAction'])->name('MyEventAction');
    Route::post('/my-event/update/{id}', [EventGalleryController::class, 'UpdateEvent'])->name('UpdateEvent');
    Route::get('/register-event', [EventGalleryController::class, 'registerEvent'])->name('registerEvent');

});

//User Approval By Admin
Route::middleware('admin')->group(function(){
    Route::get('/member-list',[UserController::class, 'index'])->name('userList');
    Route::get('/delete-user/{id}',[UserController::class, 'destroy'])->name('delete');
    Route::get('/approve-user/{id}',[UserController::class, 'approve'])->name('approve');
    Route::get('/return-user/{id}',[UserController::class, 'return'])->name('return');
    Route::get('/demote-user/{id}',[UserController::class, 'demote'])->name('demote');
    Route::get('/promote-user/{id}',[UserController::class, 'promote'])->name('promote');
    Route::match(['GET', 'POST', 'PATCH','PUT'],('/admin-dashboard'),[UserController::class, 'dashboard'])->name('dashboard');
    Route::match(['GET', 'POST', 'PATCH','PUT'],('/admin-frontend'),[UserController::class, 'frontend'])->name('frontend');
    Route::get('/admin-dashboard/allNotice',[UserController::class,'AllNotice'])->name('AllNotice');
    Route::get('/admin-dashboard/allNotice',[UserController::class,'AllEvent'])->name('AllEvent');

    // Important communication Link
    // Route::get('/cips_test',[UserController::class,'index_cips'])->name('cips_test');
    Route::post('/cips_upload',[UserController::class,'upload_cips'])->name('cips_upload');
    Route::post('/cips_update',[UserController::class,'cips_update'])->name('cips_update');
    Route::delete('/delete_cips/{id}',[UserController::class,'delete_cips'])->name('delete_cips');

    //gallery
    // Route::get('/gallery',[GalleryController::class, 'index'])->name('gallery');
    // Route::post('/gallery-create',[GalleryController::class, 'create'])->name('galleryCreate');
    // Route::get('/gallery-disabled/{id}',[GalleryController::class, 'disabled'])->name('disabled');
    // Route::get('/gallery-enable/{id}',[GalleryController::class, 'enable'])->name('enable');
    // Route::get('/gallery-editView/{id}',[GalleryController::class, 'editView'])->name('editView');
    // Route::put('/gallery-update/{id}',[GalleryController::class, 'update'])->name('GalleryUpdate');
    // Route::get('/gallery-delete/{id}',[GalleryController::class, 'delete'])->name('GalleryDelete');

    Route::get('/our-gallery',[GalleryController::class, 'ourIndex'])->name('ourGallery');
    Route::post('/our-gallery-create',[GalleryController::class, 'ourCreate'])->name('ourGalleryCreate');
    Route::get('/our-gallery-disabled/{id}',[GalleryController::class, 'ourDisabled'])->name('ourDisabled');
    Route::get('/our-gallery-enable/{id}',[GalleryController::class, 'ourEnable'])->name('ourEnable');
    Route::get('/our-gallery-editView/{id}',[GalleryController::class, 'ourEditView'])->name('ourEditView');
    Route::put('/our-gallery-update/{id}',[GalleryController::class, 'ourUpdate'])->name('ourGalleryUpdate');
    Route::get('/our-gallery-delete/{id}',[GalleryController::class, 'ourDelete'])->name('ourGalleryDelete');

    //Home gallery
    Route::get('/home-gallery',[GalleryController::class, 'index'])->name('homeGallery');
    Route::post('/home-gallery-create',[GalleryController::class, 'create'])->name('homeGalleryCreate');
    Route::get('/home-gallery-disabled/{id}',[GalleryController::class, 'disabled'])->name('homeDisabled');
    Route::get('/home-gallery-enable/{id}',[GalleryController::class, 'enable'])->name('homeEnable');
    Route::get('/home-gallery/edit/{id}',[GalleryController::class, 'editView'])->name('homeEditView');
    Route::put('/home-gallery-update/{id}',[GalleryController::class, 'update'])->name('homeGalleryUpdate');
    Route::get('/home-gallery-delete/{id}',[GalleryController::class, 'delete'])->name('homeGalleryDelete');


    //Notice
    Route::get('/all-Notice',[NoticeController::class,'AllNotice'])->name('ViewAllNotice');
    Route::get('/delete-Notice/{id}',[NoticeController::class, 'destroy'])->name('deleteNotice');
    Route::get('/approve-Notice/{id}',[NoticeController::class, 'approve'])->name('approveNotice');
    Route::get('/deactivate-Notice/{id}',[NoticeController::class,'Deactivate'])->name('deactivateNotice');
    
    //Event
    Route::get('/all-Event',[EventGalleryController::class,'AllEvent'])->name('ViewAllEvent');
    Route::get('/all-event-registration',[EventGalleryController::class,'allEventRegistration'])->name('allEventRegistration');
    Route::get('/event_reg_member_list',[EventGalleryController::class,'eventRegMemberList'])->name('event_reg_member_list');
    Route::get('/delete-Event/{id}',[EventGalleryController::class, 'destroy'])->name('deleteEvent');
    Route::get('/approve-Event/{id}',[EventGalleryController::class, 'approve'])->name('approveEvent');
    Route::get('/deactivate-Event/{id}',[EventGalleryController::class,'Deactivate'])->name('deactivateEvent');

    //Committee
    Route::get('/all-committee',[CommitteeController::class,'allCommittee'])->name('AllCommittee');
    Route::get('/edit-Committee/{id}',[CommitteeController::class,'editCommittee'])->name('EditCommittee');
    Route::get('/delete-committee/{id}',[CommitteeController::class,'deleteCommittee'])->name('DeleteCommittee');
    Route::post('/add-committee',[CommitteeController::class,'addCommittee'])->name('AddCommittee');
    Route::put('/update-committee/{id}',[CommitteeController::class,'updateCommittee'])->name('UpdateCommittee');

    //Committee Member
    Route::get('/get-all-committee',[MemberController::class,'GetAllCommittee'])->name('GetAllCommittee');
    Route::get('/get-all-committee-member',[MemberController::class,'GetAllCommitteeMember'])->name('GetAllCommitteeMember');
    Route::post('/add-committee-memeber',[MemberController::class,'addCommitteeMember'])->name('AddCommitteeMember');
    Route::get('/edit-Committee-member/{id}',[MemberController::class,'editCommitteeMember'])->name('EditCommitteeMember');
    Route::post('/update-committee-member/{id}',[MemberController::class,'updateCommitteeMember'])->name('UpdateCommitteeMember');
    Route::get('/delete-committee-member/{id}',[MemberController::class,'deleteCommitteeMember'])->name('DeleteCommitteeMember');
    Route::get('/committee-member-show/{id}',[MemberController::class,'committeeMemberShow'])->name('CommitteeMemberShow');
    Route::get('/member-enable/{id}',[MemberController::class, 'enable'])->name('MemberEnable');
    Route::get('/member-disabled/{id}',[MemberController::class, 'disabled'])->name('MemberDisabled');

    //About
    Route::get('/admin-about',[ShowcaseAboutController::class,'index'])->name('adminAbout');
    Route::post('/admin-about/save',[ShowcaseAboutController::class,'store'])->name('saveAbout');
    Route::get('/admin-about/edit/{id}',[ShowcaseAboutController::class,'edit'])->name('editAbout');
    Route::post('/admin-about/saveUpdate/{id}',[ShowcaseAboutController::class,'update'])->name('updateAbout');
    Route::get('/admin-about/delete/{id}',[ShowcaseAboutController::class, 'destroy'])->name('deleteAbout');

    //resources route role & permission
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('permissionStore', [RoleController::class, 'permissionStore'])->name('settings.permissionStore');

    //user route
    Route::patch('/admin-dashboard/user/update/{id}', [UserController::class, 'update'])->name('user.update');

    

    //persona information
    Route::get('/approve-request/{id}',[PersonalINformationController::class, 'approveRequest'])->name('user.approve');
    Route::get('/reject-request/{id}',[PersonalINformationController::class, 'rejectRequest'])->name('user.reject');



    //popup notice
    Route::resource('popup_notices', PopupNoticeController::class);
    //active button
    Route::patch('/popup-notices/{popupNotice}/toggle', [PopupNoticeController::class, 'toggleStatus'])->name('popup_notices.toggle');

});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/update/personal', [ProfileController::class, 'updatePersonal'])->name('profile.update.personal');
    Route::post('/profile/update/education', [ProfileController::class, 'updateEducation'])->name('profile.update.education');
    Route::post('/profile/update/employment', [ProfileController::class, 'updateEmployment'])->name('profile.update.employment');
    Route::post('/profile/update/accomplishments', [ProfileController::class, 'updateAccomplishments'])->name('profile.update.accomplishments');
    Route::post('/profile/update/other', [ProfileController::class, 'updateOther'])->name('profile.update.other');
    Route::post('/profile/photo/update', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::post('/profile/submit-status', [ProfileController::class, 'submitStatus'])->name('profile.submit.status');
    Route::post('/profile/submit-auth', [ProfileController::class, 'authStatus'])->name('profile.submit.auth');


    // Leadership Messages
    Route::get('/profile/messages', [LeadershipMessageController::class, 'edit'])->name('profile.editMessages');
    Route::post('/profile/messages', [LeadershipMessageController::class, 'update'])->name('profile.updateMessages');
});

require __DIR__ . '/auth.php';
