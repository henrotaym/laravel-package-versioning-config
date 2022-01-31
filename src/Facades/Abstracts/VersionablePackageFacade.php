<?php
namespace Henrotaym\LaravelPackageVersioning\Facades\Abstracts;

use Illuminate\Support\Facades\Facade;
use Henrotaym\LaravelPackageVersioning\Traits\HavingPackageClass;

abstract class VersionablePackageFacade extends Facade
{
    use HavingPackageClass;

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return static::getPackagePrefix();
    }
}