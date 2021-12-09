<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

class RoleController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();

        return view('roles.create', compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $createdRole = Role::create($validatedRequest);

        //присваиваем разрешение/разрешения
        if (isset($validatedRequest['permissions'])) {
            $createdRole->attachPermissions($validatedRequest['permissions']);
        }

        return redirect()->route('roles.index')->with('success', 'Роль создана.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();

        return view('roles.edit', compact('role', 'permissionGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $validatedRequest = $request->validated();

        //при попытке поменять данные в роли администратора/партнера данные name не должны измениться
        if ($role->name == 'administrator') {
            $validatedRequest['name'] = 'administrator';
        } else if ($role->name == 'partner') {
            $validatedRequest['name'] = 'partner';
        }

        $role->update($validatedRequest);

        //обновляем разрешение/разрешения
        if (isset($validatedRequest['permissions']) && $role->name != 'administrator') {
            $role->syncPermissions($validatedRequest['permissions']);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Роль отредактирована.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $role->delete();
        if ($request->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }
}
