<?php

namespace Phalconvee\Paga\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Phalconvee\LaravelPaga\Skeleton\SkeletonClass
 */
class Paga extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'paga';
    }
}
