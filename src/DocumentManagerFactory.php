<?php

namespace Delta4op\Mongodb;

use Delta4op\Mongodb\Managers\DocumentManager;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager as DoctrineDocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\MongoDBException;
use Illuminate\Contracts\Foundation\Application;
use MongoDB\Client;

class DocumentManagerFactory
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    public function __construct()
    {

    }

    /**
     * @param $config
     * @return DoctrineDocumentManager
     * @throws MongoDBException
     */
    public function make($config): DoctrineDocumentManager
    {
        return DoctrineDocumentManager::create(
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
        $configuration->setProxyDir($config['proxies']['path']);
        $configuration->setProxyNamespace($config['proxies']['namespace']);
        $configuration->setHydratorDir($config['hydrators']['path']);
        $configuration->setHydratorNamespace($config['hydrators']['namespace']);
        $configuration->setMetadataDriverImpl(AnnotationDriver::create($config['paths']));
        $configuration->setDefaultDB($config['database']);
        $configuration->setDefaultDocumentRepositoryClassName($config['default_document_repository']);
//        $config->setMetadataDriverImpl(new XmlDriver($config['metadata']));
        $configuration->setDefaultCommitOptions([]);

        return $configuration;
    }
}
