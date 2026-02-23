<?php
namespace Henrotaym\LaravelPackageVersioning\Testing\Traits;

use PHPUnit\Framework\Attributes\Test;

/** Adding a test installing package as versioned. */
trait InstallPackageTest
{
    #[Test]
    public function installing_package_as_versioned_test()
    {
        $this->assertTrue($this->app->make(static::getPackageClass())->install());
    }
}