<?php

namespace App\Http\Controllers;

use App\Models\GetParam;
use Illuminate\Http\Request;
use App\Http\Requests\GetParamStoreRequest;
use App\Http\Requests\GetParamUpdateRequest;

class GetParamController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(GetParam::class, 'get_param');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getParams = GetParam::get();
        return view('getParams.index', compact('getParams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('getParams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GetParamStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $createdGetParam = GetParam::create($validatedRequest);
        return redirect()->route('get-params.index')->with('success', 'GET-параметр создан.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GetParam  $getParam
     * @return \Illuminate\Http\Response
     */
    public function show(GetParam $getParam)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GetParam  $getParam
     * @return \Illuminate\Http\Response
     */
    public function edit(GetParam $getParam)
    {
        return view('getParams.edit', compact('getParam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GetParam  $getParam
     * @return \Illuminate\Http\Response
     */
    public function update(GetParamUpdateRequest $request, GetParam $getParam)
    {
        $validatedRequest = $request->validated();
        $getParam->update($validatedRequest);
        return redirect()->route('get-params.index')->with('success', 'GET-параметр отредактирован.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GetParam  $getParam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, GetParam $getParam)
    {
        $getParam->delete();
        if ($request->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }
}
