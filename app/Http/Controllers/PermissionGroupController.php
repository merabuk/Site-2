<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionGroupStoreRequest;
use App\Http\Requests\PermissionGroupUpdateRequest;

class PermissionGroupController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(PermissionGroup::class, 'permission_group');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissionGroups = PermissionGroup::get();
        return view('permissionGroups.index', compact('permissionGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::where('permission_group_id', null)->get();

        return view('permissionGroups.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionGroupStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $createdPermissionGroup = PermissionGroup::create($validatedRequest);

        //присваиваем разрешение/разрешения
        if (isset($validatedRequest['permissions'])) {
            foreach ($validatedRequest['permissions'] as $key => $id) {
                $permission = Permission::findOrFail($id);
                $permission->permission_group_id = $createdPermissionGroup->id;
                $permission->save();
            }
        }

        return redirect()->route('permission-groups.index')->with('success', 'Группа разрешений создана.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return \Illuminate\Http\Response
     */
    public function show(PermissionGroup $permissionGroup)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionGroup $permissionGroup)
    {
        $permissions = Permission::where('permission_group_id', $permissionGroup->id)->orWhere('permission_group_id', null)->get();

        return view('permissionGroups.edit', compact('permissionGroup', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionGroupUpdateRequest $request, PermissionGroup $permissionGroup)
    {
        $validatedRequest = $request->validated();

        $permissionGroup->update($validatedRequest);

        // старые разрешения
        $oldPermissionsIds =  $permissionGroup->permissions->pluck('id')->toArray();

        // проверка на убранные разрешения
        if (isset($validatedRequest['permissions']) && isset($oldPermissionsIds)) {
            if (count($validatedRequest['permissions']) >= count($oldPermissionsIds)) {
                $diffPermissionsIds = array_diff($validatedRequest['permissions'], $oldPermissionsIds);
            } else if (count($validatedRequest['permissions']) < count($oldPermissionsIds)) {
                $diffPermissionsIds = array_diff($oldPermissionsIds, $validatedRequest['permissions']);
            }
        } else if (isset($oldPermissionsIds)) {
            $diffPermissionsIds = $oldPermissionsIds;
        }
        // удаляем снятые разрешения
        if (isset($diffPermissionsIds)) {
            foreach ($diffPermissionsIds as $key => $id) {
                $permission = Permission::findOrFail($id);
                $permission->permission_group_id = null;
                $permission->save();
            }
        }
        //присваиваем выбранные разрешения
        if (isset($validatedRequest['permissions'])) {
            foreach ($validatedRequest['permissions'] as $key => $id) {
                $permission = Permission::findOrFail($id);
                $permission->permission_group_id = $permissionGroup->id;
                $permission->save();
            }
        }

        return redirect()->route('permission-groups.index')->with('success', 'Группа разрешений отредактирована.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PermissionGroup $permissionGroup)
    {
        $permissionGroup->delete();
        if ($request->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }
}
