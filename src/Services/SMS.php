<?php


namespace Media365\Transmitter\Services;


interface SMS
{
    public function send(string $mobile, string $text);
}
