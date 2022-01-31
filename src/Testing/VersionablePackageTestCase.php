<?php
namespace Henrotaym\LaravelPackageVersioning\Testing;

use Henrotaym\LaravelHelpers\Providers\HelperServiceProvider;
use Henrotaym\LaravelPackageVersioning\Providers\LaravelPackageVersioningServiceProvider;
use Henrotaym\LaravelPackageVersioning\Traits\HavingPackageClass;
use Henrotaym\LaravelTestSuite\TestSuite;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class VersionablePackageTestCase extends BaseTestCase
{
    use TestSuite, HavingPackageClass;
    
    /**
     * Providers used bu application (manual registration is compulsory)
     * 
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return array_merge($this->getDefaultServiceProviders(), $this->getServiceProviders());
    }

    /**
     * Getting service providers to add to default ones.
     * 
     * @return array
     */
    abstract public function getServiceProviders(): array;

    /**
     * Getting default service providers
     * 
     * @return array
     */
    protected function getDefaultServiceProviders()
    {
        return [
            HelperServiceProvider::class,
            LaravelPackageVersioningServiceProvider::class
        ];
    }
}