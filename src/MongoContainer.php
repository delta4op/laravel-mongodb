<?php

namespace Delta4op\Mongodb;

use Delta4op\Mongodb\Managers\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use MongoDB\Client;

class MongoContainer
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * The database connection factory instance.
     *
     * @var DocumentManagerFactory
     */
    protected DocumentManagerFactory $factory;

    /**
     * The active connection instances.
     *
     * @var array<string, DocumentManager>
     */
    protected array $managers = [];

    /**
     * Create a new document manager container instance.
     *
     * @param $app
     * @param DocumentManagerFactory $factory
     */
    public function __construct($app, DocumentManagerFactory $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }

    /**
     * @param string|null $name
     * @return DocumentManager
     * @throws MongoDBException
     */
    public function manager(string $name = null): DocumentManager
    {
        $name = $name ?? $this->defaultConnectionName();

        $config = $this->connectionConfig($name);

        if (! isset($this->managers[$name])) {
            $this->managers[$name] = $this->factory->make($config);
        }

        return $this->managers[$name];
    }

    /**
     * @param $name
     * @return array
     */
    protected function connectionConfig($name): array
    {
        $connections = $this->app['config']['mongodb.connections'];

        if (is_null($config = Arr::get($connections, $name))) {
            throw new InvalidArgumentException("Database connection [{$name}] not configured.");
        }

        return $config;
    }

    /**
     * Get the default connection name.
     *
     * @return string
     */
    protected function defaultConnectionName(): string
    {
        return $this->app['config']['mongodb.default'];
    }
}
