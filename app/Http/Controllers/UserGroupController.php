<?php

namespace App\Http\Controllers;

use App\Models\LeadGroup;
use App\Models\UserGroup;
use App\Models\User;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use App\Http\Requests\UserGroupStoreRequest;
use App\Http\Requests\UserGroupUpdateRequest;

class UserGroupController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(UserGroup::class, 'user_group');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userGroups = UserGroup::get();
        return view('userGroups.index', compact('userGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();

        return view('userGroups.create', compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserGroupStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $createdUserGroup = UserGroup::create($validatedRequest);

        //присваиваем разрешение/разрешения
        if (isset($validatedRequest['permissions'])) {
            $createdUserGroup->attachPermissions($validatedRequest['permissions']);
        }

        return redirect()->route('user-groups.index')->with('success', 'Группа пользователей создана.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show(UserGroup $userGroup)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(UserGroup $userGroup)
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();

        $users = User::with('roles')->whereNotIn('id', $userGroup->users->pluck('id'))->get();
        //фильтрация пользователей без роли админа
        $unGroupUsers = $users->filter(function ($user) {
            if ($user->roles->first()->name == 'administrator'){
                return false;
            } else {
                return true;
            }
        });

        $LeadGroups = LeadGroup::with('userGroups')->get();
        //фильтрация групп лидов не привязанных к группе пользователей
        $unGroupLeadGroups = $LeadGroups->filter(function ($leadGroup) use ($userGroup){
            if ($leadGroup->userGroups->isNotEmpty()) {
                if (in_array($userGroup->id, $leadGroup->userGroups->pluck('id')->toArray())){
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        });

        return view('userGroups.edit', compact('userGroup', 'unGroupUsers', 'permissionGroups', 'unGroupLeadGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UserGroupUpdateRequest $request, UserGroup $userGroup)
    {
        $validatedRequest = $request->validated();

        $userGroup->update($validatedRequest);

        //присваиваем разрешение/разрешения
        if (isset($validatedRequest['permissions'])) {
            $userGroup->syncPermissions($validatedRequest['permissions']);
        } else {
            $userGroup->syncPermissions([]);
        }

        return redirect()->route('user-groups.index')->with('success', 'Группа пользователей отредактирована.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UserGroup $userGroup)
    {
        $userGroup->delete();
        if ($request->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }

    /**
     * Исключить пользователя из группы.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function removeUserFromGroup(Request $request, UserGroup $userGroup, User $user)
    {
        if ($request->ajax()) {
            $userGroup->users()->detach($user->id);
            return response('deleted');
        }
    }

    /**
     * Исключить пользователя из группы.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function removeUsersFromGroup(Request $request, UserGroup $userGroup)
    {
        if ($request->ajax()) {
            if (isset($request['usersIds'])) {
                $userGroup->users()->detach($request['usersIds']);
                return response('deleted');
            }
            return response('fail');
        }
    }

    /**
     * Прикрепить пользователя/пользователей к группе.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function addUsersToGroup(Request $request, UserGroup $userGroup)
    {
        if ($request->ajax()) {
            if (isset($request['usersIds'])) {
                $userGroup->users()->attach($request['usersIds']);
                return response('added');
            }
            return response('fail');
        }
    }

    /**
     * Открепить группу лидов от группы пользователей.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @param  \App\Models\LeadGroup $leadGroup
     * @return \Illuminate\Http\Response
     */
    public function removeLeadGroupFromGroup(Request $request, UserGroup $userGroup, LeadGroup $leadGroup)
    {
        if ($request->ajax()) {
            $userGroup->leadGroups()->detach($leadGroup->id);
            return response('deleted');
        }
    }

    /**
     * Открепить группу лидов от группы пользователей.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function removeLeadGroupsFromGroup(Request $request, UserGroup $userGroup)
    {
        if ($request->ajax()) {
            if (isset($request['leadGroupsIds'])) {
                $userGroup->leadGroups()->detach($request['leadGroupsIds']);
                return response('deleted');
            }
            return response('fail');
        }
    }

    /**
     * Прикрепить группу/группы лидов к группе пользователей.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function addLeadGroupsToGroup(Request $request, UserGroup $userGroup)
    {
        if ($request->ajax()) {
            if (isset($request['leadGroupsIds'])) {
                $userGroup->leadGroups()->attach($request['leadGroupsIds']);
                return response('added');
            }
            return response('fail');
        }
    }
}
