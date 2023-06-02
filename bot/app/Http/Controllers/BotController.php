<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\Form;
use Illuminate\Http\Request;
use PhpParser\Builder\Method;

/**
 * Summary of Bot
 */
class BotController extends Controller
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
        $country=Bot::all();
        return view('create', compact ('country'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request ,Form $form)
    {
       $form->updateOrCreate(
            ['name' => $request->countries], 
            ['sender_id' => $request->input('sender_id')], 
            ['message' => $request->message]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Bot $bot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bot $bot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bot $bot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bot $bot)
    {
        //
    }
}
