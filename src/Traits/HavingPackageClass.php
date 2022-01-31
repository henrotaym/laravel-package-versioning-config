<?php
namespace Henrotaym\LaravelPackageVersioning\Traits;

use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\VersionablePackageContract;

trait HavingPackageClass
{
    /**
     * Getting package class that should be used.
     *
     * Class has to implement VersionablePackageContract.
     * 
     * @see VersionablePackageContract
     * @return string
     */
    abstract public static function getPackageClass(): string;

    /**
     * Getting package prefix that should be used.
     * 
     * @see VersionablePackageContract 
     * @return string
     */
    public static function getPackagePrefix(): string
    {
        return static::getPackageClass()::getPrefix();
    }
}