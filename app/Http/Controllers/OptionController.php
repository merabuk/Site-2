<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionSaveRequest;

class OptionController extends Controller
{
    /**
     * Display all options.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('options.index');
    }

    /**
     * Save all options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(OptionSaveRequest $request)
    {
        $validatedRequest = $request->validated();
        //автораспределение лидов
        ($validatedRequest['auto_leads_ctrl']) ? option(['auto_leads_ctrl' => true]) : option(['auto_leads_ctrl' => false]);
        return redirect()->route('options.index')->with('success', 'Настройки сохранены');
    }
}
