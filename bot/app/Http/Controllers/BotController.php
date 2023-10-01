<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\Data;
use Exception;
use Illuminate\Http\Request;

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
    public function store(Request $request ,Bot $bot , )
    {
        //Find the object throw the id from form in DB
        if (!$request->countries=='') {
                preg_match('/(?P<digit>\d+)/', $request->countries, $matches);
                $country=intval($matches[1],0);
                $data=$bot->all();
                $data= $data->find($country)->toArray();

                //upload the object to db
                $bot::where('name','=',$data['name'])->update(

                        ['sender_id' => $request->input('sender_id'),
                        'message' => $request->message]);


                        return redirect()->route('create');
                }else {
                throw new Exception("Select at least 1 country from select list ",0,null );
                }


            }
            /**
             * Display the specified resource.
             */
            public function show(Request $request,Bot $bot)
            {
                if($request)
                {

                    $query = $request->get('query');
                    
                        if ($query !='') {
                        $data=$bot->find($query);
                        return json_encode($data,true);
                        }else
                        return ('there was an error .try again');

                 }
        }
            /**
             * Show the form for editing the specified resource.
             */
            public function edit($id,Bot $bot )
            {
               $obje= $bot->find($id);
               $country=$bot->all();
               return view("create", compact ("obje","country"));
            }

            /**
             * Update the specified resource in storage.
             */
            public function update(Request $request,Bot $bot  )
            {

                $country=$bot->all();
                $data=$bot->find();
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
            public function importData(Bot $bot,Data $data)
    {
            foreach ($data->data as $item)
            {
                    $template=$data->template;
                    $sender=$data->sender;
                    Bot::updateOrCreate(
                    ['name' => $item['name'], 'code' => $item['code'],
                    'timezone' => $item['timezone'],
                    'utc' => $item['utc'],'mobilecode' => $item['mobilecode']],
                    ['sender_id' => $sender,'message' => $template ]);
            }

            $country=Bot::all();
            return view('create', compact ('country'));

    }
}
