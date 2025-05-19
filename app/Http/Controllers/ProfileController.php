<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Education;
use App\Models\Employment;
use App\Models\LanguageProficiency;
use App\Models\Person;
use App\Models\Personal;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserAccomplishment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updatePersonal(Request $request)
    {
        $user = Auth::user();

        // Validate inputs (optional but recommended)
        $request->validate([
            'name' => 'nullable|string|max:255',
            'f_name' => 'nullable|string|max:255',
            'm_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:255',
            'cips_membership_status' => 'nullable|string|max:255',
            'present_address' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'career_type' => 'nullable|string|max:255',
            'service_category_id' => 'nullable|string|max:255',
            'service_sub_category_id' => 'nullable|string|max:255',
            'career_objective' => 'nullable|string|max:255',
            'short_biography' => 'nullable|string|max:255',
            'number_of_child' => 'nullable|string|max:255',
            'mobile_no' => 'nullable|string|max:255',
            'alt_mobile_no' => 'nullable|string|max:255',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

    $person = Person::where('user_id', $user->id)->first();

    if ($person) {
        $person->update([
            'name' => $request->name,
            'f_name' => $request->f_name,
            'm_name' => $request->m_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'marital_status' => $request->marital_status,
            'nationality' => $request->nationality,
            'nid' => $request->nid,
            'cips_membership_status' => $request->cips_membership_status,
            'present_address' => $request->present_address,
            'permanent_address' => $request->permanent_address,
            'career_type' => $request->career_type,
            'service_type' => $request->service_category_id,
            'member_sub_subcategory_id' => $request->service_sub_category_id,
            'number_of_child' => $request->number_of_child,
            'mobile_no' => $request->mobile_no,
            'alt_mobile_no' => $request->alt_mobile_no,
            'career_objective' => $request->career_objective,
            'short_biography' => $request->short_biography,

            // 'profileImage' => $request->file('profileImage') ? $request->file('profileImage')->store('images') : $person->profileImage,
        ]);
    } else {
        return back()->with('error', 'No personal record found to update.');
    }

    return back()->with('success', 'Personal information updated.');
}


public function updateEducation(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'degree_title.*' => 'nullable|string|max:255',
        'major_subject.*' => 'nullable|string|max:255',
        'education_institute.*' => 'nullable|string|max:255',
        'result.*' => 'nullable|string|max:100',
        'passing_year.*' => 'nullable|string|max:10',
    ]);

    // Use the correct foreign key
    Education::where('person_id', $user->id)->delete();

    $titles = $request->input('degree_title', []);

    foreach ($titles as $index => $title) {
        if (trim($title) !== '') {
            Education::create([
                'person_id'       => $user->id,
                'degree_title'  => $title,
                'major_subject'   => $request->major_subject[$index] ?? '',
                'education_institute' => $request->education_institute[$index] ?? '',
                'result'          => $request->result[$index] ?? '',
                'passing_year' => $request->passing_year[$index] ?? '',
            ]);
        }
    }

    return back()->with('success', 'Education information updated successfully.');
}



    public function updateEmployment(Request $request)
    {
        $user = Auth::user();
        Employment::where('user_id', $user->id)->delete();

        foreach ($request->organization as $index => $organization) {
            if ($organization) {
                Employment::create([
                    'user_id' => $user->id, 
                    'organization' => $organization,
                    'designation' => $request->designation[$index] ?? '',
                    'department' => $request->department[$index] ?? '',
                    'duration' => $request->duration[$index] ?? '',
                ]);
            }
        }

        return back()->with('success', 'Employment history updated.');
    }



    public function updateAccomplishments(Request $request)
    {
        $request->validate([
            'accomplishments.*.type' => 'nullable|string|max:100',
            'accomplishments.*.title' => 'nullable|string|max:255',
            'accomplishments.*.issued_on' => 'nullable|date',
            'accomplishments.*.url' => 'nullable|url',
            'accomplishments.*.description' => 'nullable|string',
            'accomplishments.*.files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        $userId = Auth::id();
        $submittedIds = [];

        $accomplishments = $request->input('accomplishments', []);

        foreach ((array) $accomplishments as $index => $accomplishment) {
            $filePaths = [];

            // Handle new file uploads manually to public/uploads
            if ($request->hasFile("accomplishments.$index.files")) {
                foreach ($request->file("accomplishments.$index.files") as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $destination = public_path('uploads/accomplishments');
                    $file->move($destination, $filename);
                    $filePaths[] = 'uploads/accomplishments/' . $filename;
                }
            }

            $data = [
                'user_id' => $userId,
                'type' => $accomplishment['type'],
                'title' => $accomplishment['title'],
                'issued_on' => $accomplishment['issued_on'] ?? null,
                'url' => $accomplishment['url'] ?? null,
                'description' => $accomplishment['description'] ?? null,
            ];

            if (!empty($accomplishment['id'])) {
                $existing = UserAccomplishment::where('id', $accomplishment['id'])
                    ->where('user_id', $userId)
                    ->first();

                if ($existing) {
                    $existingFiles = $existing->files ?? [];

                    // Handle file deletions
                    $deletedFiles = $request->input("accomplishments.$index.deleted_files", []);
                    foreach ($deletedFiles as $deletedFile) {
                        if (in_array($deletedFile, $existingFiles)) {
                            $filePath = public_path($deletedFile);
                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }
                            $existingFiles = array_diff($existingFiles, [$deletedFile]);
                        }
                    }

                    // Merge remaining existing files + new files
                    $data['files'] = array_values(array_merge($existingFiles, $filePaths));
                    $existing->update($data);
                    $submittedIds[] = $existing->id;
                }
            } else {
                // Create new record
                $data['files'] = $filePaths;
                $new = UserAccomplishment::create($data);
                $submittedIds[] = $new->id;
            }
        }

        // Delete removed accomplishments
        $oldRecords = UserAccomplishment::where('user_id', $userId)
            ->whereNotIn('id', $submittedIds)
            ->get();

        foreach ($oldRecords as $record) {
            foreach ($record->files ?? [] as $file) {
                $filePath = public_path($file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $record->delete();
        }

        return back()->with('success', 'Accomplishments saved successfully!');
    }





    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        $person = Person::where('user_id', $user->id)->first();

        if (!$person) {
            return response()->json(['error' => 'No personal record found to update.'], 404);
        }

        // Delete old photo (if exists)
        if ($person->profileImage && file_exists(public_path($person->profileImage))) {
            unlink(public_path($person->profileImage));
        }

        // Save new photo manually in public/uploads/profile_photos
        $file = $request->file('photo');
        $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = 'uploads/profile_photos';
        $file->move(public_path($destinationPath), $filename);

        $relativePath = $destinationPath . '/' . $filename;

        $person->update([
            'profileImage' => $relativePath,
        ]);

        return response()->json([
            'new_photo_url' => asset($relativePath)
        ]);
    }


public function updateOther(Request $request)
{
    $user = person::where('user_id', Auth::id())->first();

    DB::transaction(function () use ($request, $user) {
        $user->update([
            'skill_description' => $request->input('skill_description'),
        ]);

        // Delete old skills and languages
        Skill::where('user_id', $user->id)->delete();
        LanguageProficiency::where('user_id', $user->id)->delete();

        // Save skills
        if ($request->has('skills')) {
            foreach ($request->input('skills') as $skill) {
                Skill::create([
                    'user_id' => $user->id,
                    'name' => $skill['name'] ?? '',
                    'learned_by' => $skill['learned_by'] ?? [],
                ]);
            }
        }

        // Save language proficiencies
        if ($request->has('languages')) {
            foreach ($request->languages as $language) {
                if (!isset($language['name']) || !isset($language['level'])) {
                    continue; 
                }

                LanguageProficiency::create([
                    'user_id' => $user->id,
                    'language' => $language['name'],
                    'speaking' => $language['level'], 
                    'writing' => $language['level'],
                    'reading' => $language['level'],
                ]);
            }
        }
    });

    return back()->with('success', 'Skills and languages updated successfully!');
}

    public function submitStatus(Request $request)
    {
        $user = Person::where('user_id', Auth::id())->first();
        if (!$user) {
            return response()->json(['error' => 'No personal record found.'], 404);
        }
        $user->status = 2;
        $user->save();

        $user = auth()->user(); 
        $user->status = 2;
        $user->save();

        $userStatus = User::where('id', Auth::id())->first();

        if ($userStatus) {
            $userStatus->status = 2;
            $userStatus->save();
        }

        return response()->json(['success' => true]);
    }

        public function authStatus(Request $request)
    {
        $user = Person::where('user_id', Auth::id())->first();
        if (!$user) {
            return response()->json(['error' => 'No personal record found.'], 404);
        }
        $user->status = 3;
        $user->save();

        $user = auth()->user(); 
        $user->status = 3;
        $user->save();

        $userStatus = User::where('id', Auth::id())->first();

        if ($userStatus) {
            $userStatus->status = 3;
            $userStatus->save();
        }

        return response()->json(['success' => true]);
    }

}
