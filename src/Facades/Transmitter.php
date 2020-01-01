<?php

namespace Media365\Transmitter\Facades;

class Transmitter extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Transmitter';
    }

}
