<?php
namespace Henrotaym\LaravelPackageVersioning\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Henrotaym\LaravelPackageVersioning\Package;
use Henrotaym\LaravelPackageVersioning\Tests\TestCase;

class VersionablePackageTest extends TestCase
{
    #[Test]
    public function get_version_returns_package_json_version()
    {
        $package = $this->app->make(Package::class);
        $packageJson = json_decode(file_get_contents($package->getPathToPackageJson()));

        $this->assertEquals($packageJson->version, $package->getVersion());
    }

    #[Test]
    public function get_config_and_set_config_use_prefixed_key()
    {
        $package = $this->app->make(Package::class);

        $package->setConfig('test_key', 'test_value');
        $this->assertEquals('test_value', $package->getConfig('test_key'));
        $this->assertEquals('test_value', config($package->getPrefix() . '.test_key'));
    }

    #[Test]
    public function get_prefix_returns_correct_prefix()
    {
        $package = $this->app->make(Package::class);

        $this->assertEquals('laravel_package_versioning_config', $package->getPrefix());
    }
}
