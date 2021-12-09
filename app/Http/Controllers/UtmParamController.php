<?php

namespace App\Http\Controllers;

use App\Models\UtmParam;
use Illuminate\Http\Request;
use App\Http\Requests\UtmParamStoreRequest;
use App\Http\Requests\UtmParamUpdateRequest;

class UtmParamController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(UtmParam::class, 'utm_param');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utmParams = UtmParam::get();
        return view('utmParams.index', compact('utmParams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('utmParams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UtmParamStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $createdUtmParam = UtmParam::create($validatedRequest);
        return redirect()->route('utm-params.index')->with('success', 'UTM-параметр создан.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UtmParam  $utmParam
     * @return \Illuminate\Http\Response
     */
    public function show(UtmParam $utmParam)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UtmParam  $utmParam
     * @return \Illuminate\Http\Response
     */
    public function edit(UtmParam $utmParam)
    {
        return view('utmParams.edit', compact('utmParam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UtmParam  $utmParam
     * @return \Illuminate\Http\Response
     */
    public function update(UtmParamUpdateRequest $request, UtmParam $utmParam)
    {
        $validatedRequest = $request->validated();
        $utmParam->update($validatedRequest);
        return redirect()->route('utm-params.index')->with('success', 'UTM-параметр отредактирован.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UtmParam  $utmParam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UtmParam $utmParam)
    {
        $utmParam->delete();
        if ($request->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }
}
