<?php

namespace App\External\Persistence;

use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use Cake\Database\StatementInterface;
use Database;

class MysqlDatabase implements DatabaseInterface
{

    private $connection;

    public function __construct()
    {
        $driver = new Mysql(Database::getConfig('default'));
        $this->connection = new Connection(compact('driver'));
    }

    /**
     * @inheritdoc
     */
    public function execute(string $query)
    {
        $statement = $this->connection->execute($query);

        return $statement->fetchAll(StatementInterface::FETCH_TYPE_OBJ);
    }

    /**
     * @inheritdoc
     */
    public function select(string $table, array $fields, array $conditions): array
    {
        $query = $this->connection->newQuery();
        $query->select($fields)
            ->from($table)
            ->where($conditions);

        return $query->execute()->fetchAll(StatementInterface::FETCH_TYPE_OBJ) ?? [];
    }

    /**
     * @inheritdoc
     */
    public function insert(string $table, array $data): bool
    {
        $statement = $this->connection->insert('users', $data);

        return $statement->count() > 0;
    }

    /**
     * @inheritdoc
     */
    public function update(string $table, array $data, array $conditions): bool
    {
        $statement = $this->connection->update($table, $data, $conditions);

        return $statement->rowCount() > 0;
    }

    /**
     * @inheritdoc
     */
    public function delete(string $table, array $conditions): bool
    {
        $statement = $this->connection->delete('users', $conditions);

        return $statement->count() > 0;
    }
}
