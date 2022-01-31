<?php
namespace Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts;

use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\VersionablePackageContract;
use stdClass;

/** Versioning finder. */
interface VersioningRepositoryContract
{
    /**
     * Getting package version from package.json.
     * 
     * @param VersionablePackageContract $package.
     * @return string
     */
    public function getVersion(VersionablePackageContract $package): string;

    /**
     * Getting package version from package.json.
     * 
     * @param VersionablePackageContract $package.
     * @return PackageJsonContract
     */
    public function getPackageJson(VersionablePackageContract $package): PackageJsonContract;
}