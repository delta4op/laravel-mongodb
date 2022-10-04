<?php

namespace Delta4op\Mongodb;

use Delta4op\Mongodb\Exception\InvalidConfigurationException;
use Delta4op\Mongodb\Managers\DocumentManager;
use Delta4op\Mongodb\Repositories\DocumentRepository;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\MongoDBException;
use MongoDB\Client;
use Throwable;

class DocumentManagerFactory
{
    public function __construct() {}

    /**
     * @param string $connectionName
     * @param array $config
     * @return DocumentManager
     * @throws MongoDBException
     * @throws Throwable
     */
    public function make(string $connectionName, array $config): DocumentManager
    {
        $this->validateConfig($connectionName, $config);

        return DocumentManager::create(
            $this->makeConnection($config),
            $this->makeConfiguration($config)
        );
    }

    /**
     * @throws Throwable
     */
    public function validateConfig(string $connectionName, array $config): void
    {
        throw_if(
            !isset($config['dsn']) < 1,
            new InvalidConfigurationException("dsn not defined for connection $connectionName")
        );

        throw_if(
            !isset($config['database']) < 1,
            new InvalidConfigurationException("database not defined for connection $connectionName")
        );

        throw_if(
            !isset($config['paths']) < 1,
            new InvalidConfigurationException("paths not defined for connection $connectionName")
        );
    }

    /**
     * @param array $config
     * @return Client
     */
    protected function makeConnection(array $config): Client
    {
        return new Client(
            $config['dsn'],
            [],
            ['typeMap' => DocumentManager::CLIENT_TYPEMAP]
        );
    }

    /**
     * @param array $config
     * @return Configuration
     * @throws MongoDBException
     */
    protected function makeConfiguration(array $config): Configuration
    {
        $configuration = new Configuration();

        $configuration->setMetadataDriverImpl(AnnotationDriver::create($config['path']));
        $configuration->setDefaultDB($config['database']);
        $configuration->setDefaultDocumentRepositoryClassName(
            $config['defaultRepository'] ?? $this->defaultRepositoryClassName()
        );

        if(isset($config['proxies'])) {
            $configuration->setProxyDir(
                $config['proxies']['path'] ?? $this->defaultProxyPath()
            );

            $configuration->setProxyNamespace(
                $config['proxies']['namespace'] ?? $this->defaultProxyNamespace()
            );
        }

        if(isset($config['hydrators'])) {
            $configuration->setHydratorDir(
                $config['hydrators']['path'] ?? $this->defaultHydratorsPath()
            );

            $configuration->setHydratorNamespace(
                $config['hydrators']['namespace'] ?? $this->defaultHydratorsNamespace()
            );
        }

        $configuration->setDefaultCommitOptions([]);

        return $configuration;
    }

    /**
     * @return string
     */
    public function defaultProxyPath(): string
    {
        return storage_path('proxies');
    }

    /**
     * @return string
     */
    public function defaultProxyNamespace(): string
    {
        return 'Proxies';
    }

    /**
     * @return string
     */
    public function defaultHydratorsPath(): string
    {
        return storage_path('hydrators');
    }

    /**
     * @return string
     */
    public function defaultHydratorsNamespace(): string
    {
        return 'Hydrators';
    }

    /**
     * @return string
     */
    public function defaultRepositoryClassName(): string
    {
        return DocumentRepository::class;
    }
}
