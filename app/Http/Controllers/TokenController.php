<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Requests\TokenStoreRequest;
use App\Http\Requests\TokenUpdateRequest;

class TokenController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Token::class, 'token');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tokens = Token::get();
        return view('tokens.index', compact('tokens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tokens.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TokenStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TokenStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $createdBrand = Token::create($validatedRequest);
        return redirect()->route('tokens.index')->with('success', 'Токен создан.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function show(Token $token)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function edit(Token $token)
    {
        return view('tokens.edit', compact('token'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\TokenUpdateRequest  $request
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function update(TokenUpdateRequest $request, Token $token)
    {
        $validatedRequest = $request->validated();
        $token->update($validatedRequest);
        return redirect()->route('tokens.index')->with('success', 'Токен отредактирован.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Token $token)
    {
        $token->delete();
        if ($request->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }
}
