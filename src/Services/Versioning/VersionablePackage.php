<?php
namespace Henrotaym\LaravelPackageVersioning\Services\Versioning;

use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\VersionablePackageContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\VersioningRepositoryContract;

/** Versionable package. */
abstract class VersionablePackage implements VersionablePackageContract
{
    /**
     * Getting prefix statically.
     * 
     * @return string
     */
    abstract public static function prefix(): string;

    /**
     * @var VersioningRepositoryContract
     */
    protected $versioning_repository;

    public function __construct(VersioningRepositoryContract $versioning_repository)
    {
        $this->versioning_repository = $versioning_repository;
    }

    /**
     * Getting path to package.json.
     * 
     * @return string
     */
    public function getPathToPackageJson(): string
    {
        return $this->getPathToRoot('package.json');
    }

    /**
     * Getting pach to root location.
     * 
     * @param string $path
     * @return string
     */
    protected function getPathToRoot(string $path = null): string
    {
        return app()->make(HelpersContract::class)->getDirectory(static::class) . "/../$path";
    }

    /**
     * Getting package version.
     * 
     * @return string
     */
    public function getVersion(): string
    {
        return $this->versioning_repository->getVersion($this);
    }

    /**
     * Getting package prefix.
     * 
     * @return string
     */
    public function getPrefix(): string
    {
        return static::prefix();
    }

    /**
     * Getting config value.
     * Prefix is automatically added to given key.
     * 
     * @param string $key key to get in config file. If none->getting whole package config.
     * @return mixed
     */
    public function getConfig(string $key = null)
    {
        return config($this->getPrefix(). ($key ? ".$key" : ''));
    }

    /**
     * Installing this package.
     * 
     * @return bool
     */
    public function install(): bool
    {
        return $this->versioning_repository->getPackageJson($this)
            ->addScripts()
            ->save();
    }
}