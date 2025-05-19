<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Actions\Role\CreateRole;
use App\Actions\Role\UpdateRole;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\RoleFormRequest;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Console\Descriptor\Descriptor;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->latest()->get();
        $permissions = Permission::latest()->get();

        $users = User::with(['roles'])->latest()->get();

        return response()->json(['message' => 'Role Fatch Successfull', 'data' => $roles, 'permissions' => $permissions, 'users' => $users, 'status' => 200]);
    }

    public function getRoles()
    {
        $user = User::find(Auth::user()->id);

        $roles = Role::all();

        return response()->json(['message' => 'Role Fatch Successfull', 'data' => $roles, 'status' => 200]);
    }

    public function getPermissions()
    {
        $permissions = Permission::all();

        return response()->json(['message' => 'Permission Fatch Successfull', 'data' => $permissions, 'status' => 200]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        // $permission_groups = User::getPermissionGroup();

        return view('role.create', compact(['permissions']));
    }

    /**
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => "required|unique:roles,name"
    //     ]);

    //     $role = Role::create(['name' => $request->name , 'guard_name'=>'web']);
        
    //     $permissions = [];
    //     foreach($request->permissions as $payloadkey){
    //         $get_header_keys = Permission::where('id', '=', $payloadkey)->get();
    //         array_push($permissions,$get_header_keys);
    //     }
    //     $role->syncPermissions($permissions);

    //     return response()->json(['message' => 'Role Created Successfully!']);
    // }

    public function permissionStore(Request $request)
    {
        try {
            $request->validate([
                'name' => "required|unique:roles,name",
                'permission' => 'array',
                'permission.*' => 'exists:permissions,id',
            ]);
    
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
    
            // Get permission models and sync
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $role->syncPermissions($permissions);
    
            $role->load('permissions');
    
            return response()->json([
                'message' => 'Role created successfully!',
                'data' => $role,
            ]);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        $permissions = Permission::all();
        $role = Role::with('permissions')->find($id);
        $data = $role->permissions->pluck('id')->toArray();

        return response()->json(['role' => $role, 'permissions' => $permissions, 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => "required|unique:roles,name, $role->id"
        ]);

        $role->update(['name'=>$request->name]);
        $permissions = [];
        foreach($request->permissions as $payloadkey){
            $get_header_keys = Permission::where('id', '=', $payloadkey)->get();
            array_push($permissions,$get_header_keys);
        }
        $role->syncPermissions($permissions);

        return response()->json(['message' => 'Role Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

         return response()->json(['message' => 'Role Deleted Successfully!']);

    }
}
