<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 19:05
 */

namespace DataAggregator\Store;

use DataAggregator\Entry;
use DataAggregator\Store\StoreException;

class MySqlStore implements StoreInterface
{
    const TABLE_ENTRY = 'aggregator_entry';
    const TABLE_USER = 'aggregator_user';

    /**
     * @var array
     */
    private $config = [
        'db' => null,
        'host' => null,
        'user' => null,
        'password' => null
    ];

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @param array $config
     * @throws \DataAggregator\Store\StoreException
     */
    public function __construct(array $config)
    {
        $this->configIsValid($config);

        $this->config = $config;
    }

    /**
     * Checks if configuration is valid.
     *
     * @param array $config
     * @throws \DataAggregator\Store\StoreException
     */
    private function configIsValid(array $config)
    {
        foreach ($this->config as $param => $value) {
            if (!array_key_exists($param, $config)) {
                throw new StoreException('Config is invalid.');
            }
        }
    }

    /**
     * Connects to MySql database using PDO extension.
     *
     * @throws \DataAggregator\Store\StoreException
     */
    public function connect()
    {
        $url = sprintf('mysql:host=%s;dbname=%s', $this->config['host'], $this->config['db']);

        try {
            $this->pdo = new \PDO($url, $this->config['user'], $this->config['password']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
        } catch (\PDOException $ex) {
            throw new StoreException($ex);
        }

    }

    /**
     * Adds an Entry object to the database. Entry object contains User and Messages data.
     *
     * @param Entry $entry
     * @return int
     * @throws \DataAggregator\Store\StoreException
     */
    public function add(Entry $entry)
    {
        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare(sprintf("INSERT INTO %s (provider_id) VALUES(:provider_id)", self::TABLE_USER));
        $stmt->bindValue(':provider_id', $entry->getId(), \PDO::PARAM_STR);
        $rowCount = 0;
        try {
            $stmt->execute();
            $userId = $this->pdo->lastInsertId();
            $rowCount += $this->prepareMultiInsert($userId, $entry->getMessages());
            $this->pdo->commit();

        } catch (\PDOException $ex) {
            $this->pdo->rollBack();
            throw new StoreException('Problem with Insert statement.');
        }

        $rowCount += $stmt->rowCount();

        return $rowCount;
    }

    /**
     * Prepares one query to add multiple insert.
     *
     * @param $userId User identity
     * @param array $messages Messages to add
     * @return int Number of added rows
     */
    private function prepareMultiInsert($userId, array $messages)
    {
        $query = sprintf("INSERT INTO %s(user_id, content) VALUES ", self::TABLE_ENTRY);
        $part = array_fill(0, count($messages), "(?, ?)");
        $query .=  implode(",",$part);

        $stmt = $this->pdo->prepare($query);

        $i = 1;
        /** @var \DataAggregator\Message[] $messages */
        foreach ($messages as $message) {
            $stmt->bindValue($i++, $userId);
            $stmt->bindValue($i++, $message->getContent());
        }

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function get($limit = 10)
    {
        // TODO: Implement get() method.
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}