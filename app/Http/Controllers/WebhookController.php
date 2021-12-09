<?php

namespace App\Http\Controllers;

use App\Models\Webhook;
use App\Models\UtmParam;
use App\Models\GetParam;
use Illuminate\Http\Request;
use App\Http\Requests\WebhookStoreRequest;
use App\Http\Requests\WebhookUpdateRequest;

class WebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webhooks = Webhook::get();
        $utms = UtmParam::orderBy('name')->get();
        $gets = GetParam::orderBy('name')->get();
        $params = $utms->concat($gets)->sortBy('order');
        return view('options.webhooks.index', compact('webhooks', 'params'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $utms = UtmParam::orderBy('name')->get();
        $gets = GetParam::orderBy('name')->get();
        $params = $utms->concat($gets)->sortBy('order');
        return view('options.webhooks.create', compact('params'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebhookStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $createdWebhook = Webhook::create($validatedRequest);
        return redirect()->route('webhooks.index')->with('success', 'Вебхук создан.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Webhook  $webhook
     * @return \Illuminate\Http\Response
     */
    public function show(Webhook $webhook)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Webhook  $webhook
     * @return \Illuminate\Http\Response
     */
    public function edit(Webhook $webhook)
    {
        $utms = UtmParam::orderBy('name')->get();
        $gets = GetParam::orderBy('name')->get();
        $params = $utms->concat($gets)->sortBy('order');
        return view('options.webhooks.edit', compact('webhook', 'params'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Webhook  $webhook
     * @return \Illuminate\Http\Response
     */
    public function update(WebhookUpdateRequest $request, Webhook $webhook)
    {
        $validatedRequest = $request->validated();
        $webhook->update($validatedRequest);
        return redirect()->route('webhooks.index')->with('success', 'Вебхук обновлен.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Webhook  $webhook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Webhook $webhook)
    {
        $webhook->delete();
        if ($request->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }
}
