<?php
namespace Henrotaym\LaravelPackageVersioning\Providers\Abstracts;

use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Henrotaym\LaravelPackageVersioning\Commands\InstallVersioningPackage;
use Illuminate\Support\ServiceProvider;
use Henrotaym\LaravelPackageVersioning\Traits\HavingPackageClass;
use Reflection;
use ReflectionClass;

abstract class VersionablePackageServiceProvider extends ServiceProvider
{
    use HavingPackageClass;

    /**
     * Registering things to app.
     * 
     * @return void
     */
    public function register()
    {
        $this->bindFacade()
            ->registerConfig();
    }

    /**
     * Binding facade.
     * 
     * @return static
     */
    protected function bindFacade()
    {
        $this->app->bind(static::getPackagePrefix(), function($app) {
            return $app->make(static::getPackageClass());
        });

        return $this;
    }
    
    /**
     * Registering config
     * 
     * @return static
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom($this->getConfigPath(), static::getPackagePrefix());

        return $this;
    }

    /**
     * Registering given command.
     * 
     * @var string $command_class
     * @return static
     */
    protected function registerCommand(string $command_class)
    {
        if ($this->app->runningInConsole()):
            $this->commands([$command_class]);
        endif;
        
        return $this;
    }

    /**
     * Booting application.
     * 
     * @return void
     */
    public function boot()
    {
        $this->makeConfigPublishable()
            ->registerCommand(InstallVersioningPackage::class);
    }

    /**
     * Allowing config publication.
     * 
     * @return self
     */
    protected function makeConfigPublishable(): self
    {
        if ($this->app->runningInConsole()):
            $this->publishes([
              $this->getConfigPath() => config_path(static::getPackagePrefix() . '.php'),
            ], 'config');
        endif;

        return $this;
    }

    /**
     * Getting config path.
     * 
     * @return string
     */
    protected function getConfigPath(): string
    {
        return $this->app->make(HelpersContract::class)->getDirectory(static::class) .'/../config/config.php';
    }
}