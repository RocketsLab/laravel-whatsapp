<?php

namespace RocketsLab\LaravelWhatsapp\Facades;

use Illuminate\Support\Facades\Facade;

class Whatsapp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \RocketsLab\LaravelWhatsapp\Whatsapp::class;
    }
}
