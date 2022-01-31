<?php
namespace Henrotaym\LaravelPackageVersioning;

use Henrotaym\LaravelPackageVersioning\Contracts\PackageContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\VersionablePackage;

class Package extends VersionablePackage implements PackageContract
{
    public static function prefix(): string
    {
        return "laravel_package_versioning_config";
    }
}