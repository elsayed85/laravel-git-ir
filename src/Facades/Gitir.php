<?php

namespace Elsayed85\Gitir\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Elsayed85\Gitir\Giti
 */
class Gitir extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Elsayed85\Gitir\Gitir::class;
    }
}
