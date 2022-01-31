<?php
namespace Henrotaym\LaravelPackageVersioning\Tests;

use Henrotaym\LaravelPackageVersioning\Package;
use Henrotaym\LaravelPackageVersioning\Testing\VersionablePackageTestCase;

class TestCase extends VersionablePackageTestCase
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }
    
    public function getServiceProviders(): array
    {
        return [];
    }
}