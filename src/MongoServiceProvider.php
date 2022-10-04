<?php

namespace Delta4op\Mongodb;

use Delta4op\Mongodb\Console\Commands\DocumentMakeCommand;
use Doctrine\ODM\MongoDB\Types\Type;
use Delta4op\Mongodb\Types\CarbonDate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MongoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('delta4op/laravel-mongodb')->hasConfigFile('mongodb');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function bootingPackage(): void
    {
        $this->publishes([
            __DIR__.'/../config/mongodb.php' => config_path('mongodb.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                DocumentMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function registeringPackage(): void
    {
        // The factory class is used to create the document manager instances
        // We will inject the factory into the mongo container so that it may
        // make the managers while they are actually needed and not of before.
        $this->app->singleton('mongodb.factory', function ($app) {
            return new DocumentManagerFactory();
        });

        // The database manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
        $this->app->singleton('mongodb', function ($app) {
            return new MongoContainer($app, $app['mongodb.factory']);
        });

        $this->registerCustomTypes();
    }

    /**
     * Registers custom type casting
     *
     * @return void
     */
    protected function registerCustomTypes(): void
    {
        Type::registerType('carbon', CarbonDate::class);

        if(($types = config('mongodb.types')) && is_array($types)) {
            foreach($types as $name => $class) {
                Type::registerType($name, $class);
            }
        }
    }
}
