<?php

namespace App\Services;



class SaveData
{

    public static function saveData($request, $bot)
    {
        $data = $request->all();



        if ($data['sender_id']== null || $data['message'] == null) {
            return false;
        } else {


            //find and update record  to db
            $bot::where('name', $data['countries'])->update(

                [
                    'sender_id' => $request->sender_id,
                    'message' => $request->message
                ]
            );


            return true;
        }
    }
}
