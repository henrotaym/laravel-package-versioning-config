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
    protected function getPathToRoot(?string $path = null): string
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
        return $this->getVersioningRepository()->getVersion($this);
    }

    /**
     * Getting versioning repository.
     * 
     * @return VersioningRepositoryContract
     */
    protected function getVersioningRepository(): VersioningRepositoryContract
    {
        return app()->make(VersioningRepositoryContract::class);
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
    public function getConfig(?string $key = null)
    {
        return config($this->getPrefixedKey($key));
    }

    /**
     * Setting config value.
     * Prefix is automatically added to given key.
     * 
     * @param string $key key to get in config file. If none->getting whole package config.
     * @param mixed $value
     * @return static
     */
    public function setConfig(?string $key = null, $value): VersionablePackageContract
    {
        config([$this->getPrefixedKey($key) => $value]);

        return $this;
    }

    /**
     * Prefixing given key with package prefix.
     * 
     * @param string Package config key.
     * @return string
     */
    protected function getPrefixedKey(?string $key): string
    {
        return $this->getPrefix(). ($key ? ".$key" : '');
    }

    /**
     * Installing this package.
     * 
     * @return bool
     */
    public function install(): bool
    {
        return $this->getVersioningRepository()->getPackageJson($this)
            ->addScripts()
            ->save();
    }
}