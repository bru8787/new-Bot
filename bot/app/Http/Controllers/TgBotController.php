<?php

namespace App\Http\Controllers;
use App\Services\CheckCommand;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TgBotController extends Controller
{

    public function inbound(Request $request)
    {

            $check = new CheckCommand($request);
            $check->check($request);

    }
    public function setupHook()
    {
        try {
            $response = Telegram::setWebhook(['url' => config('telegram.webhook_url')]);
            return $response == true ? 'webhook setup' : 'webhook failed';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}

