<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => "required|unique:permissions,name"
            ]);
    
            $permission = Permission::create(['name' => $request->name , 'guard_name'=>'web']);

            return response()->json(['message' => 'Permission created successfully!', 'data' => $permission]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permissions = Permission::find($id);

        return response()->json(['permissions' => $permissions, 'status' => 200, 'message' => 'Permission Fatch Successfull']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required|unique:permissions,name"
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->save();

        return response()->json(['message' => 'Permission Updated Successfully!', 'data' => $permission, 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        return response()->json(['message' => 'Permission Deleted Successfully!', 'status' => 200]);
    }
}
