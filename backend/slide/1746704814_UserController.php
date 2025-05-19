<?php

namespace App\Http\Controllers;

use App\Models\ModelHasRole;
use App\Models\Otp;
use App\Models\User;
use App\Models\Designation;
use App\Notifications\SendVerifySMS;
use App\Models\UserProfile;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);

        return response()->json(['message' => 'User Fatch Successfull', 'data' => $users, 'status' => 200]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::latest()->get();

        return response()->json(['roles' => $roles, 'status' => 200, 'message' => 'Role Fatch Successfull']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validation = Validator::make($request->all(),
            [
                'name' => 'required|max:80',
                'password' => 'required|min:6|',
                'password_confirmation' => 'required|same:password',
                'email' => 'required|email|unique:users,email',
                'roles' => 'required',
                'designation_id' => 'nullable|exists:designations,id',
                'auth_id' => 'nullable|exists:users,id',
                'department_id' => 'nullable|exists:departments,id',
            ]);

            if($validation->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validation->errors()
                ]);
            }

            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = date('ymd') . '.' . time() . '.' . $image->getClientOriginalName();
                $image->move(base_path('public/global_assets/user_images'), $imageName);
                $photo = $imageName;
            } else {
                $photo = null;
            }

            if($request->hasFile('signature')){
                $signature = $request->file('signature');
                $signatureName = date('ymd') . '.' . time() . '.' . $signature->getClientOriginalName();
                $signature->move(base_path('public/global_assets/user_images/signature'), $signatureName);
                $signature = $signatureName;
            } else {
                $signature = null;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password_confirmation),
                'profile_photo_path' => $photo,
                'email_verified_at' => now(),
                'designation_id' => $request->designation_id,
                'auth_by' => $request->auth_id,
                'signature' => $signature,
                'department_id' => $request->department_id,
            ]);

            if(!$user){
                return response()->json(['message' => 'User not created!', 'status' => false], 422);
            }

            $user->syncRoles($request->roles);

            return response()->json(['message' => 'User created successfully!', 'data' => $user, 'status' => true], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage(), 'status' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
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
        try{

            $user = User::with(['userhasRole.role'])->find($id);

            return $user;

            if(!$user){
                return response()->json(['message' => 'User not found!', 'status' => 404], 404);
            }

            return response()->json(['message' => 'User Fatch Successfull', 'data' => $user, 'status' => 200]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|max:80',
                'email' => 'required|email',
                'roles' => 'nullable',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
                'designation_id' => 'nullable|exists:designations,id',
                'auth_id' => 'nullable|exists:users,id',
                'department_id' => 'nullable|exists:departments,id',
            ]);

            // Update basic user information
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation_id = $request->designation_id;
            $user->auth_by = $request->auth_id;
            $user->department_id = $request->department_id;

            // Store the old profile photo path
            $oldPhotoPath = $user->profile_photo_path;

            // ... your existing update logic

            // Delete the old profile photo if it exists
            if ($request->hasFile('photo') && $oldPhotoPath) {
                // Delete the old image from the storage
                Storage::delete('public/global_assets/user_images/' . $oldPhotoPath);
            }

            //delete signature
            $oldSignaturePath = $user->signature;

            if ($request->hasFile('signature') && $oldSignaturePath) {
                // Delete the old image from the storage
                Storage::delete('public/global_assets/user_images/signature/' . $oldSignaturePath);
            }

            // Update profile photo if provided
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = date('ymd') . '.' . time() . '.' . $image->getClientOriginalName();
                $image->move(base_path('public/global_assets/user_images'), $imageName);
                $user->profile_photo_path = $imageName;
            }

            // Update signature if provided
            if ($request->hasFile('signature')) {
                $signature = $request->file('signature');
                $signatureName = date('ymd') . '.' . time() . '.' . $signature->getClientOriginalName();
                $signature->move(base_path('public/global_assets/user_images/signature'), $signatureName);
                $user->signature = $signatureName;
            }

            $user->save();

            $user->syncRoles($request->roles);

            return response()->json(['message' => 'User updated successfully!', 'data' => $user, 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function userProfileUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|max:80',
                'email' => 'required|email',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            ]);

            $user = User::findOrFail($id);

            if(!$user){
                return response()->json(['message' => 'User not found!', 'status' => false], 404);
            }

            // Update basic user information
            $user->name = $request->name;
            $user->email = $request->email;

            // Store the old profile photo path
            $oldPhotoPath = $user->profile_photo_path;

            // ... your existing update logic

            // Delete the old profile photo if it exists
            if ($request->hasFile('photo') && $oldPhotoPath) {
                // Delete the old image from the storage
                Storage::delete('public/global_assets/user_images/' . $oldPhotoPath);
            }

            // Update profile photo if provided
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = date('ymd') . '.' . time() . '.' . $image->getClientOriginalName();
                $image->move(base_path('public/global_assets/user_images'), $imageName);
                $user->profile_photo_path = $imageName;
            }

            $user->save();

            return response()->json(['message' => 'User updated successfully!', 'data' => $user, 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => false, 'message' => 'User not updated!']);
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
        // $model = ModelHasRole::where('model_id', $id)->first();

        // if($model){
        //     $model->delete();
        // }

        try{

            $userHasRole = ModelHasRole::where('model_id', $id)->first();

            if ($userHasRole) {
                $userHasRole->where('model_id', $id)->delete();
            }

            $userData = User::find($id);
            if ($userData) {
                $userData->is_active = 0;
                $userData->save();
                return response()->json(['message' => 'User Deleted Successfully!', 'status' => 200]);
            } else {
                return response()->json(['message' => 'User not found!', 'status' => 404], 404);
            }
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function profile()
    {
        return view('backend.pages.profiles');
    }

    public function showProfile()
    {
        try{
            $user = User::with(['userhasRole.role', 'department', 'designation'])->find(auth()->user()->id);

            // this sql for get designation and others information from khulna
            // $user = User::with(['userhasRole.role'])
            //         ->join('designations', 'users.designation_id', '=', 'designation.id') 
            //         ->where('users.id', auth()->user()->id) 
            //         ->select('users.*', 'designation.*') 
            //         ->first();

            if(!$user){
                return response()->json(['message' => 'User not found!', 'status' => 404], 404);
            }

            return response()->json(['message' => 'User Fatch Successfull', 'data' => $user, 'status' => 200]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function changePassword(Request $request)
    {
        try{
            $request->validate([
                'old_password' => 'required',
                'password' => 'required|min:6|',
                'password_confirmation' => 'required',
            ]);

            $user = User::findOrFail(auth()->user()->id);

            if(!password_verify($request->old_password, $user->password)){
                return response()->json(['message' => 'Old password not match!', 'status' => 422], 422);
            }

            if($request->password == $request->old_password){
                return response()->json(['message' => 'New password can not be same as old password!', 'status' => 422], 422);
            }

            if($request->password_confirmation !== $request->password){
                return response()->json(['message' => 'Password not match!', 'status' => 422], 422);
            }

            $user->password = bcrypt($request->password_confirmation);
            $user->save();

            $user = User::find(Auth::id());

            $reorderedRoleIds = session('reorderedRoleIds');

            if($reorderedRoleIds){
                $user->syncRoles($reorderedRoleIds);
            }

            session()->flush();
            session()->regenerateToken();
            session()->invalidate();

            $this->guard->logout();

            return response()->json(['message' => 'Password changed successfully!', 'status' => 200]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // Activate a user
    public function activeUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Activate the user
        $user->is_active = 1;

        // Restore the original email if it was modified during deactivation
        if (preg_match('/_([0-9]{4})_[0-9]{4}-[0-9]{2}-[0-9]{2}/', $user->email)) {
            $user->email = Str::before($user->email, '_') . '@' . Str::afterLast($user->email, '@');
        }

        $user->save();

        return response()->json(['message' => 'User activated successfully'], 200);
    }

    // Deactivate a user
    public function deactiveUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Deactivate the user
        $user->is_active = 0;

        // Generate a unique serial number
        $currentDate = now()->format('Y-m-d');
        $baseEmail = Str::before($user->email, '@');
        $domain = Str::after($user->email, '@');

        $existingEmails = User::where('email', 'like', $baseEmail . '_%_' . $currentDate . '@' . $domain)->pluck('email');
        $serial = 1;

        while ($existingEmails->contains($baseEmail . '_' . str_pad($serial, 4, '0', STR_PAD_LEFT) . '_' . $currentDate . '@' . $domain)) {
            $serial++;
        }

        $user->email = $baseEmail . '_' . str_pad($serial, 4, '0', STR_PAD_LEFT) . '_' . $currentDate . '@' . $domain;

        $user->save();

        return response()->json(['message' => 'User deactivated successfully'], 200);
    }

    // Reset a user's password
    public function passReset($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Reset the password to a default value
        $defaultPassword = '123456789'; // Replace with your desired default password
        $user->password = Hash::make($defaultPassword);

        $user->save();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}