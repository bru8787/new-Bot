<?php

namespace App\Http\Controllers;
use App\Services\CheckCommand;
use Illuminate\Http\Request;






class TgBotController extends Controller
{

    public function inbound(Request $request)
    {

            $check = new CheckCommand($request);
            $check->check($request);

    }

}

