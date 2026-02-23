<?php
namespace Henrotaym\LaravelPackageVersioning\Facades\Abstracts;

use Illuminate\Support\Facades\Facade;
use Henrotaym\LaravelPackageVersioning\Traits\HavingPackageClass;

/**
 * @method static string getConfig(string $key) Getting package config value.
 * @method static string setConfig(string $key, $value) Setting package config value.
 * @method static string getVersion() Getting package version.
 * @method static string getPrefix() Getting package prefix.
 */
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
    protected static function getFacadeAccessor(): string
    {
        return static::getPackagePrefix();
    }
}