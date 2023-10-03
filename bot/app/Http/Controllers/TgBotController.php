<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;



class TgBotController extends Controller
{

    protected $match;
    protected $text;
    protected  $param = [
        'chat_id',
        'from_chat_id',
        'reply_to_message',
        'text',


    ];
    public function inbound(Request $request)
    {
        if (!key_exists("text",$request->message) ) {
            die();
        } else {
            $this->setParam('chat_id', $request->message['chat']['id']);
            $this->setParam('from_chat_id', $request->message['from']['id']);
            $this->setParam('reply_to_message', $request->message['message_id']);

            if ($request->string('bot_command')) {
                $bot_command = ltrim($request->message['text'], '/');
                Log::info($bot_command);

                if ($bot_command !== 'start') {
                     $this->checkCommand($bot_command);
                } elseif ($bot_command == 'start') {
                    $this->setParam('text', 'Hello Buddy, nice to meet you !');
                    $this->Send($this->param);
                }
            }
        }
    }
    /**
     * @param mixed $bot_command
     * @return void
     */
    protected function checkCommand($bot_command)
    {
        $bot = new Bot;
        $this->match =  $bot::where('name', '=', $bot_command)->get();
        $this->match = $this->match->toArray();
        $bot_command = Str::ucfirst($bot_command);
        if (!empty($this->match)) {
            Log::info($this->match);
            $this->text = 'Sender id: ' . '' . $this->match[0]['sender_id'] . ''
                . $this->match[0]['message'];
            $this->setParam('text', $this->text);
            $this->Send($this->param);
        } else {
            $this->setParam('text', 'please write correctly a name of a country , there should be a typo!');

            $this->Send($this->param);
        }
    }
    /**
     * @param mixed $param
     * @return self
     */
    public function setParam($key, $param): self
    {
        $this->param[$key] = $param;
        return $this;
    }
    protected function Send($data)
    {
        if ($data) {
            Telegram::sendMessage($data);
        }
    }

    /**
     * @param mixed $text
     * @return self
     */
    public function setText($text): self
    {
        $this->text = $text;
        return $this;
    }
}
