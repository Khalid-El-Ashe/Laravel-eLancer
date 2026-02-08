<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Currency extends Facade
{

    /**
     * Summary of getFacadeAccessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'currency';
    }
}
