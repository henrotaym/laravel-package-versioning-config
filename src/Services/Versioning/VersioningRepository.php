<?php
namespace Henrotaym\LaravelPackageVersioning\Services\Versioning;

use Exception;
use Symfony\Component\Process\Process;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\PackageJsonContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\VersionablePackageContract;
use Henrotaym\LaravelPackageVersioning\Services\Versioning\Contracts\VersioningRepositoryContract;

/** Versioning finder. */
class VersioningRepository implements VersioningRepositoryContract
{
    /**
     * @var HelpersContract
     */
    protected $helpers;

    /**
     * Injecting dependencies
     * 
     * @var HelpersContract $helpers
     * @return void
     */
    public function __construct(HelpersContract $helpers)
    {
        $this->helpers = $helpers;
    }

    /**
     * Getting package version from package.json.
     * 
     * @param string|undefined $path_to_package_json If undefined default path will be used.
     * @return string
     */
    public function getVersion(VersionablePackageContract $package): string
    {
        $package_json = json_decode(file_get_contents($package->getPathToPackageJson()));

        return $package_json->version;
    }

    /**
     * Getting package version from package.json.
     * 
     * @param VersionablePackageContract $package.
     * @return PackageJsonContract
     */
    public function getPackageJson(VersionablePackageContract $package): PackageJsonContract
    {
        return app()->make(PackageJsonContract::class, [
            'attributes' => $this->getPackageJsonAttributes($package),
            'location' => $package->getPathToPackageJson()
        ]);
    }

    /**
     * Getting package.json attributes as array.
     * 
     * @param VersionablePackageContract $package
     * @return array
     */
    protected function getPackageJsonAttributes(VersionablePackageContract $package): array
    {
        var_dump('running');
        [$error, $attributes] = $this->helpers->try(function() use ($package) { 
            return json_decode(file_get_contents($package->getPathToPackageJson()), true);
        });

        // If file doesn't exist create one without attributes.
        if ($error):
            return $this->createPackageJson()
                ->getPackageJsonAttributes($package);
            endif;

        return $attributes ?? [];
    }

    /**
     * Creating package.json from command line using yarn init.
     * 
     * @throws ProcessFailedException
     * @return self
     */
    protected function createPackageJson(): self
    {
        $command = new Process(['yarn', '--yes', 'init']);
        $command->mustRun();

        return $this;
    }
}