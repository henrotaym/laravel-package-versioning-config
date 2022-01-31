<?php
namespace Henrotaym\LaravelPackageVersioning\Testing\Traits;

/** Adding a test installing package as versioned. */
trait InstallPackageTest
{
    /** @test */
    public function installing_package_as_versioned_test()
    {
        $this->assertTrue($this->app->make(static::getPackageClass())->install());
    }
}