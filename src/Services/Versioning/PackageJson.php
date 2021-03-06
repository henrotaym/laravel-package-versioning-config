<?php
namespace Henrotaym\LaravelPackageVersioning\Services\Versioning;

use stdClass;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\PackageJsonContract;

/**
 * Representing package json available actions.
 */
class PackageJson implements PackageJsonContract
{
    /**
     * Attributes
     * 
     * @var stdClass
     */
    protected $attributes = [];

    /**
     * Location where package.json is.
     * 
     * @var string
     */
    protected $location;

    /**
     * Helpers.
     * 
     * @var HelpersContract
     */
    protected $helpers;
    
    /**
     * Constructing based on given data
     * 
     * @param array $attributes
     * @return void
     */
    
    public function  __construct(HelpersContract $helpers, array $attributes = [], string $location)
    {
        $this->attributes = json_decode(json_encode(count($attributes) === 0 ? new stdClass : $attributes));
        $this->location = $location;
        $this->helpers = $helpers;
    }

    /**
     * Getting version
     * 
     * @return string
     */
    public function getVersion(): string
    {
        return $this->attributes->version;
    }

    /**
     * Adding expected scripts to package.
     * 
     * @return PackageJsonContract
     */
    public function addScripts(): PackageJsonContract
    {
        if (!isset($this->attributes->scripts)):
            $this->attributes->scripts = new stdClass;
        endif;

        $this->attributes->scripts->push = "git push && git push --tags";
        $this->attributes->scripts->postversion = "npm run push";
        $this->attributes->scripts->commit = "gitmoji -c && npm run push";
        $this->attributes->scripts->{'commit:all'} = "git add . && npm run commit";
        $this->attributes->scripts->{'version:alpha'} = "npm version prerelease --preid=alpha";

        return $this;
    }

    /**
     * Saving package.json.
     * 
     * @return bool
     */
    public function save(): bool
    {
        [$error, $success] = $this->helpers->try(function() {
            return file_put_contents($this->location, json_encode($this->attributes, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n");
        });

        return $error ?: $success;
    }
}