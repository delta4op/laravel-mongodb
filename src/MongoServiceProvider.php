<?php

namespace Delta4op\Mongodb;

use Doctrine\ODM\MongoDB\Types\Type;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Delta4op\Mongodb\Types\CarbonDate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MongoServiceProvider extends PackageServiceProvider
{
    /**
     * Custom type mappings
     *
     * @var array
     */
    public array $types = [];

    public function configurePackage(Package $package): void
    {
        $package->name('laravel-mongodb')->hasConfigFile('mongodb');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function bootingPackage() {
        $this->publishes([
            __DIR__.'/../config/mongodb.php' => config_path('mongodb.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function registeringPackage()
    {
        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->app->singleton('mongodb.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        // The database manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
        $this->app->singleton('mongodb', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });

        $this->registerCustomTypes();
    }

    /**
     * Registers custom type casting
     *
     * @return void
     */
    protected function registerCustomTypes()
    {
        Type::registerType('carbon', CarbonDate::class);

        foreach($this->types as $name => $class) {
            Type::registerType($name, $class);
        }
    }
}
