<?php

namespace Delta4op\Mongodb;

use Delta4op\Mongodb\Managers\DocumentManager;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\MongoDBException;
use MongoDB\Client;

class DocumentManagerFactory
{
    public function __construct() {}

    /**
     * @param $config
     * @return DocumentManager
     * @throws MongoDBException
     */
    public function make($config): DocumentManager
    {
        // todo validate connection config array

        return DocumentManager::create(
            $this->makeConnection($config),
            $this->makeConfiguration($config)
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

        if(isset($config['proxies'])) {
            $configuration->setProxyDir($config['proxies']['path']);
            $configuration->setProxyNamespace($config['proxies']['namespace']);
        }

        if(isset($config['hydrators'])) {
            $configuration->setHydratorDir($config['hydrators']['path']);
            $configuration->setHydratorNamespace($config['hydrators']['namespace']);
        }

        if(isset($config['paths'])) {
            $configuration->setMetadataDriverImpl(AnnotationDriver::create($config['paths']));
        }

        if($config['database']) {
            $configuration->setDefaultDB($config['database']);
        }

        if(isset($config['defaultRepository'])) {
            $configuration->setDefaultDocumentRepositoryClassName($config['defaultRepository']);
        }

        $configuration->setDefaultCommitOptions([]);

        return $configuration;
    }
}
