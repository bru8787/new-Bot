<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\Form;

use Exception;
use Illuminate\Http\Request;
use JavaScript;

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
    public function create(Bot $bot)
    {
        $country=$bot->all();

        return view('create', compact ('country'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request ,Bot $bot ,Form $form)
    {
        if (!$request->countries=='') {
            $id=$bot->all();
            $id = $id->intersect(Bot::whereIn('id', [$request->countries])->get());
            $id=$id[0]->id;


       $form->updateOrCreate(
            ['country_id' => $id],
            ['name' => $request->countries,
            'sender_id' => $request->input('sender_id'),
            'message' => $request->message]);

        $country=Bot::all();
        return view('create', compact ('country'));
        }else {
         throw new Exception("Select at least 1 country from select list ",0,null );
        }


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
    public function update($id,Request $request,Bot $bot, Form $form,  )
    {

        $country=$bot->all();
        $data=$form->find($id);
        echo $data;
        return view('create', compact ('country','data'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bot $bot)
    {
        //
    }
    public function importData(Bot $bot )
    {

        $data=new \App\Models\Data;
        $data=$data->data;

            foreach ($data as $item) {
                $data = Bot::updateOrCreate($item);


                $data->updateOrCreate(
                    ['name' => $item['name']],
                    ['code' => $item['code']],
                    ['timezone' => $item['timezone']],
                    ['utc' => $item['utc']],
                    ['mobilecode' => $item['mobilecode']]);
            }
            $country=Bot::all();
            return view('create', compact ('country'));

    }
}
