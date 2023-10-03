<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;



class TgBotController extends Controller
{

    protected $match;
    protected $text ;
    protected  $param = [
        'chat_id',
        'reply_to_message',
        'text',
        'from_chat_id.'

    ];
    public function inbound(Request $request)
    {
        $this->setParam('chat_id', $request->message['chat']['id']);
        $this->setParam('reply_to_message', $request->message['chat']['id']);
        $this->setParam('from_chat_id', $request->message['from']['id']);





        if ($request->string('bot_command')) {
            $bot_command = ltrim($request->message['text'], '/');
        }
        return $this->checkCommand($bot_command);
    }

    protected function checkCommand($bot_command)
    {
        if ($bot_command) {
            $bot = new Bot;
            $this->match =  $bot::where('name', '=', $bot_command)->get();
            if ($this->match) {
                $this->text='Sender id: '.''.$this->match[0]->sender_id.''
                .$this->match[0]->message;
                $this->setParam('text',$this->text);

                Log::info($this->param['text']);

            }

               $this->Send($this->param);
        }
        else {

            $this->setParam('text','ah ah not a good one!');
            Log::info($this->param['text']);
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