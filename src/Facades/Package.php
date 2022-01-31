<?php
namespace Henrotaym\LaravelPackageVersioning\Facades;

use Henrotaym\LaravelPackageVersioning\Package as Underlying;
use Henrotaym\LaravelPackageVersioning\Facades\Abstracts\VersionablePackageFacade;

class Package extends VersionablePackageFacade
{
    public static function getPackageClass(): string
    {
        return Underlying::class;
    }
}