<?php
namespace Henrotaym\LaravelPackageVersioning\Providers;

use Henrotaym\LaravelPackageVersioning\Package;
use Henrotaym\LaravelPackageVersioning\Contracts\PackageContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\PackageJson;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\VersioningRepository;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\PackageJsonContract;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\VersioningRepositoryContract;

class LaravelPackageVersioningServiceProvider extends VersionablePackageServiceProvider
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }

    protected function addToRegister(): void
    {
        $this->app->bind(PackageContract::class, Package::class);
        $this->app->bind(PackageJsonContract::class, PackageJson::class);
        $this->app->bind(VersioningRepositoryContract::class, VersioningRepository::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}