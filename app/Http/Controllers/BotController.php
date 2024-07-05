<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Bot;
use App\Models\Data;
use App\Services\SaveData;


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

        $country = $bot->all();

        return view('create', compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Bot $bot,SaveData $saveData)
    {
        $data=new SaveData;
        $data=$data->saveData( $request, $bot);



        return        ($data)?redirect()->route('create')->with('success','Data updated successfully'):
        redirect()->route('create')->with('error','There is not allowed empty lines as sender id or message,fill it in right way and try again');

    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, Bot $bot)
    {
        if ($request) {

            $query = $request->get('query');

            if ($query != '') {
                $data = $bot->where('name',$query)->first();
                return json_encode($data, true);

            } else
                return ('there was an error .try again');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Bot $bot)
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
    public function importData(Bot $bot, Data $data)
    {
        foreach ($data->data as $item) {
            $template = $data->template;
            $sender = $data->sender;
            Bot::updateOrCreate(
                [
                    'name' => $item['name'], 'code' => $item['code'],
                    'timezone' => $item['timezone'],
                    'utc' => $item['utc'], 'mobilecode' => $item['mobilecode']
                ],
                ['sender_id' => $sender, 'message' => $template]
            );
        }

        $country = Bot::all();
        return view('create', compact('country'));
    }
}
