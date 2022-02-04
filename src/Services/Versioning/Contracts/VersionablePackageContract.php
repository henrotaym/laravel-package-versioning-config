<?php
namespace Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts;

/** Versionable package. */
interface VersionablePackageContract
{
    /**
     * Getting prefix statically.
     * 
     * @return string
     */
    public static function prefix(): string;

    /**
     * Getting path to package.json.
     * 
     * @return string
     */
    public function getPathToPackageJson(): string;

    /**
     * Getting package version.
     * 
     * @return string
     */
    public function getVersion(): string;


    /**
     * Getting package prefix.
     * 
     * @return string
     */
    public function getPrefix(): string;

    /**
     * Getting config value.
     * Prefix is automatically added to given key.
     * 
     * @param string $key key to get in config file. If none->getting whole package config.
     * @return mixed
     */
    public function getConfig(string $key = null);

    /**
     * Installing this package.
     * 
     * @return bool
     */
    public function install(): bool;
}