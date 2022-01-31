<?php
namespace Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts;

/**
 * Representing package json available actions.
 */
interface PackageJsonContract
{
    /**
     * Getting version
     * 
     * @return string
     */
    public function getVersion(): string;

    /**
     * Adding expected scripts to package.
     * 
     * @return PackageJsonContract
     */
    public function addScripts(): PackageJsonContract;

    /**
     * Saving package.json.
     * 
     * @return bool
     */
    public function save(): bool;
}