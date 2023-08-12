<?php

namespace Elsayed85\Gitir\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Elsayed85\Gitir\Giti
 */
class Browse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Elsayed85\Gitir\Browser\Browse::class;
    }
}
