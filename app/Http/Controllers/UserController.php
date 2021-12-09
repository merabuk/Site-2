<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UserGroup;
use App\Models\PermissionGroup;
use App\Models\Lead;
use App\Models\GetParam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
// use App\Notifications\UserCreated;
// use App\Notifications\UserPasswordUpdated;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        $userGroups = UserGroup::get();
        $permissionGroups = PermissionGroup::with('permissions')->get();
        return view('users.create', compact('roles', 'userGroups', 'permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $validatedRequest = $request->validated();

        //сохраняем незахешированный пароль
        // $notHashPassword = $validatedRequest['password'];

        //хэшируем пароль
        $validatedRequest['password'] = Hash::make($validatedRequest['password']);

        //создаем пользователя
        $createdUser = User::create($validatedRequest);

        //присваиваем роль/роли
        $createdUser->attachRole($validatedRequest['role']);

        //присваиваем группу/группы
        if (isset($validatedRequest['userGroups'])) {
            $userGroupsIds = UserGroup::whereIn('name', $validatedRequest['userGroups'])->pluck('id');
            $createdUser->userGroups()->attach($userGroupsIds);
        }

        //присваиваем разрешение/разрешения
        if (isset($validatedRequest['permissions']) && $validatedRequest['role'] != 'administrator') {
            $createdUser->attachPermissions($validatedRequest['permissions']);
        }

        //отправляеем письмо пользователю с логином и паролем
        // $createdUser->notify(new UserCreated($createdUser, $notHashPassword));

        return redirect()->route('users.index')->with('success', 'Пользователь создан.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        $userGroups = UserGroup::with('users')->get();
        $permissionGroups = PermissionGroup::with('permissions')->get();
        $gets = GetParam::whereIn('code', ['buyer', 'phone', 'email', 'product'])->orderBy('name')->get();
        $params = $gets;

        //фильтрация групп без пользователя
        $unUserGroups = $userGroups->filter(function ($group) use ($user){
            if ($group->users->isNotEmpty()) {
                if (in_array($user->id, $group->users->pluck('id')->toArray())){
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        });

        $leads = Lead::with('users')->get();
        $unUserLeads = $leads->filter(function ($lead) use ($user){
            if ($lead->users->isNotEmpty()) {
                if (in_array($user->id, $lead->users->pluck('id')->toArray())) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        });

        return view('users.edit', compact('user', 'roles', 'permissionGroups', 'unUserGroups', 'unUserLeads', 'params'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $validatedRequest = $request->validated();
        // dd($validatedRequest);
        if (isset($validatedRequest['password'])) {
            //сохраняем незахешированный пароль
            // $notHashPassword = $validatedRequest['password'];
            //хэшируем пароль
            $validatedRequest['password'] = Hash::make($validatedRequest['password']);
        }

        //редактируем пользователя
        $user->update($validatedRequest);

        //обновляем роль/роли
        if (isset($validatedRequest['role']) && auth()->user()->hasRole('administrator')) {
            $user->syncRoles([$validatedRequest['role']]);
        }

        //обновляем разрешение/разрешения
        if (isset($validatedRequest['permissions']) && !$user->hasRole('administrator')) {
            $user->syncPermissions($validatedRequest['permissions']);
        } else {
            $user->syncPermissions([]);
        }

        //если пароль изменился
        // if (isset($notHashPassword)) {
        //     //отправляеем письмо пользователю с логином и паролем
        //     $user->notify(new UserPasswordUpdated($user, $notHashPassword));
        // }

        if (auth()->user()->id == $user->id && auth()->user()->hasRole('administrator')) {
            return redirect()->route('users.index')->with('success', 'Ваш профиль отредактирован.');
        } elseif (auth()->user()->hasRole('administrator')) {
            return redirect()->route('users.index')->with('success', 'Пользователь отредактирован.');
        } else {
            return redirect()->route('home')->with('success', 'Ваш профиль отредактирован.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if (auth()->user()->id != $user->id) {
            $user->delete();
            if ($request->ajax()) {
                return response('deleted');
            }
        }
        return redirect()->back();
    }

    /**
     * Исключить пользователя из группы.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function removeGroupFromUser(Request $request, User $user, UserGroup $userGroup)
    {
        if ($request->ajax()) {
            $user->userGroups()->detach($userGroup->id);
            return response('deleted');
        }
    }

    /**
     * Исключить пользователя из групп.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function removeGroupsFromUser(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (isset($request['userGroupsIds'])) {
                $user->userGroups()->detach($request['userGroupsIds']);
                return response('deleted');
            }
            return response('fail');
        }
    }

    /**
     * Прикрепить пользователя/пользователей к группе.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function addGroupsToUser(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (isset($request['userGroupsIds'])) {
                $user->userGroups()->attach($request['userGroupsIds']);
                return response('added');
            }
            return response('fail');
        }
    }

    /**
     * Открепить лида от пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @param  \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function removeLeadFromUser(Request $request, User $user, Lead $lead)
    {
        if ($request->ajax()) {
            $user->leads()->detach($lead->id);
            return response('deleted');
        }
    }

    /**
     * Открепить лидов от пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function removeLeadsFromUser(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (isset($request['leadsIds'])) {
                $user->leads()->detach($request['leadsIds']);
                return response('deleted');
            }
            return response('fail');
        }
    }

    /**
     * Прикрепить группу/группы лидов к группе пользователей.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function addLeadToUser(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (isset($request['leadsIds'])) {
                $user->leads()->attach($request['leadsIds']);
                return response('added');
            }
            return response('fail');
        }
    }
}
