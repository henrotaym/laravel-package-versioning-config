<?php
namespace Henrotaym\LaravelPackageVersioning\Providers\Abstracts;

use Illuminate\Support\ServiceProvider;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Henrotaym\LaravelPackageVersioning\Traits\HavingPackageClass;
use Henrotaym\LaravelContainerAutoRegister\Services\AutoRegister\Contracts\AutoRegisterContract;

abstract class VersionablePackageServiceProvider extends ServiceProvider
{
    use HavingPackageClass;

    /**
     * Adding this to service provider register() method.
     * 
     * @return void
     */
    abstract protected function addToRegister(): void;

    /**
     * Adding this to service provider boot() method.
     * 
     * @return void
     */
    abstract protected function addToBoot(): void;

    /**
     * Registering things to app.
     * 
     * @return void
     */
    public function register()
    {
        $this->bindFacade()
            ->registerConfig();
        
        $this->addToRegister();
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
            ->registerPackageContract();

        $this->addToBoot();
    }

    /**
     * Registering package contract if available.
     * 
     * Done in boot method to make sure every provider register method were fully loaded.
     * 
     * @return static
     */
    protected function registerPackageContract()
    {
        $this->app->make(AutoRegisterContract::class)->add(static::getPackageClass());

        return $this;
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