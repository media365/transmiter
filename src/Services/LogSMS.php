<?php


namespace Media365\Transmitter\Services;


use Illuminate\Support\Facades\Log;

class LogSMS implements SMS
{

    public function send(string $mobile, string $text)
    {
        Log::info("[Log Only] SMS sent to $mobile; Content: $text");
    }
}
