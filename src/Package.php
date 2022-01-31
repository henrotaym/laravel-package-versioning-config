<?php
namespace Henrotaym\LaravelPackageVersioning;

use Henrotaym\LaravelPackageVersioning\Contracts\PackageContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\VersionablePackage;
use Henrotaym\LaravelContainerAutoRegister\Services\AutoRegister\Contracts\AutoRegistrableContract;

class Package extends VersionablePackage implements PackageContract, AutoRegistrableContract
{
    public static function prefix(): string
    {
        return "laravel_package_versioning_config";
    }
}