<?php

namespace Delta4op\Mongodb\Managers;

use Doctrine\Common\EventManager;
use Doctrine\ODM\MongoDB\Configuration;
use \Doctrine\ODM\MongoDB\DocumentManager as BaseDocumentManager;
use Illuminate\Support\Arr;
use MongoDB\Client;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\RuntimeException;

class DocumentManager extends BaseDocumentManager
{
    /**
     * @var Session
     */
    private Session $session;

    public static function create(?Client $client = null, ?Configuration $config = null, ?EventManager $eventManager = null): DocumentManager
    {
        return new static($client, $config, $eventManager);
    }

    /**
     * Start transaction
     *
     * @param array $options
     */
    public function startTransaction(array $options = [])
    {
        $this->startSession();

        $options = [
                'readConcern' => new ReadConcern('snapshot'),
                'writeConcern' => new WriteConcern(WriteConcern::MAJORITY),
            ] + $options;

        $this->session->startTransaction($options);
    }


    /**
     * Commits transaction
     *
     * @return void
     */
    public function commitTransaction()
    {
        $this->session->commitTransaction();
    }

    /**
     * Aborts transaction
     *
     * @return void
     */
    public function abortTransaction()
    {
        $this->session->abortTransaction();
    }

    /**
     * Start session if it exists
     * Throws error if session does not exist
     *
     * @param array $options
     */
    public function startSession(array $options = [])
    {
        if (! isset($this->session)) {
            $options = [
                    'readPreference' => new ReadPreference(ReadPreference::RP_PRIMARY),
                ] + $options;

            $this->session = $this->getClient()->startSession($options);
        } else {
            throw new RuntimeException('Session already started.');
        }
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * Ends session if it exists
     * Throws error if session does not exist
     *
     * @return void
     */
    public function endSession()
    {
        if ($this->session instanceof Session) {
            $this->session->endSession();
        } else {
            throw new RuntimeException('Session not found.');
        }
    }

    /**
     * @param object|object[] $objects
     */
    public function persistMultiple(object|array $objects)
    {
        foreach(Arr::wrap($objects) as $object) {
            $this->persist($object);
        }
    }
}
