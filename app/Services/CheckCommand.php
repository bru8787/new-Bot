<?php

namespace App\Services;

use App\Models\Bot;
use App\Models\Data;
use Datetime;
use DateTimeZone;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class CheckCommand
{
    protected $suggested;
    protected $timezone;
    protected $match;
    protected $text;
    protected $botUsername;
    protected  $param = [
        'chat_id',
        'from_chat_id',
        'reply_to_message',
        'text',
    ];
    public function __construct($suggested = null, $timezone = null, $match = null, $text = null, $param = null , $botUsername = null) 
    {
        $this->suggested = $suggested;
        $this->timezone = $timezone;
        $this->match = $match;
        $this->text = $text;
        $this->param = $param;
        $this->botUsername = $botUsername;
    }
    public function check($request)
    {
        if ($request->message !== null && $request->message['chat']['type'] == 'private' && $request->message['from']['is_bot'] == false && $request->message['text'] !== null) {
            $this->setParam('chat_id', $request->message['chat']['id']);
            $this->setParam('from_chat_id', $request->message['from']['id']);
            $this->setParam('reply_to_message', $request->message['message_id']);

            $botCommandInput = $request->input('bot_command');
            if (isset($botCommandInput)) {
                $bot_command = ltrim($request->message['text'], '/');

                if ($bot_command !== ''&& $bot_command !== '') {
                    $this->checkCommand($bot_command);
                } elseif ($bot_command == 'start') {
                    $this->setParam('text', 'Hello Buddy, nice to meet you !');

                    $this->Send($this->param);
                }
            }else{
                return;
            }
        }
    }
    protected function checkCommand($bot_command)
    {
        $bot = new Bot;
        $this->match =  $bot::where('name', '=', $bot_command)->get();
        Log::info('this match' . [$this->match]);
        $this->match = $this->match->toArray();
        $this->suggested = $this->suggestCommand($bot_command);
        $bot_command = Str::ucfirst($bot_command);
        if (!empty($this->match)) {
            $this->timezone = $this->match[0]['utc'];
            $this->text = 'Sender id: ' . '' . $this->match[0]['sender_id'] . "\n" . "=========================" . "\n" . '**' . $this->match[0]['name'] . '**' . "\n\n" . "UTC:" . ' ' . $this->match[0]['utc'] . "\n\n" . 'Time Now :  ' . $this->getTimeByUTC($this->timezone) . "\n\n" . 'Mobile code:' . ' ' . $this->match[0]['mobilecode'] . "\n\n" . "=========================" . "\n" . $this->match[0]['message'];
            $this->setParam('text', $this->text);
            $this->Send($this->param);
        } else {

            $this->setParam('text', 'There should be a typo!' . "\n\n\n" .
                $this->suggested);

            $this->Send($this->param);
        }
    }
    protected function getTimeByUTC($offset)
    {

        if (!preg_match('/^[+-]\d{2}:\d{2}$/', $offset)) {
            return "Invalid UTC offset format.";
        }

        // Split the offset into hours and minutes
        $hours = (int)substr($offset, 1, 2);
        $hours = $hours + 1;
        Log::info($hours);
        $minutes = (int)substr($offset, 4, 2);
        if ($offset[0] === '-') {
            $hours = -$hours;
            $minutes = -$minutes;
        }

        $datetime = new DateTime('now', new DateTimeZone('UTC'));

        if ($hours) {
            $datetime->modify("{$hours} hours");
        }
        if ($minutes) {
            $datetime->modify("{$minutes} minutes");
        }

        return $datetime->format(' H:i');
    }
    protected function suggestCommand($inputCommand)
    {
        $validCommands = new Data;
        $closestDistance = PHP_INT_MAX; // Set initial closest distance to a large number
        $closestCommand = null;

        foreach ($validCommands->countryListSimple as $command) {
            $distance = levenshtein($inputCommand, $command);
            if ($distance < $closestDistance) {
                $closestDistance = $distance;
                $closestCommand = $command;
            }
        }

        // You can set a threshold here, e.g., if distance is greater than 3, maybe it's too different to be a suggestion
        if ($closestDistance <= 3) {
            return 'Do you mean: /' . $closestCommand;
        }
        return 'Too much typo to suggest any command,sorry  :(';
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
            Log::info($data);

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
