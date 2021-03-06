<?php

namespace Iqmal\LaravelFakerGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Iqmal\LaravelFakerGenerator\Skeleton\SkeletonClass
 */
class LaravelFakerGeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-faker-generator';
    }
}
