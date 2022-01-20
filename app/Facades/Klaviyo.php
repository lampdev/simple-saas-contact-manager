<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Klaviyo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'klaviyo-api';
    }
}