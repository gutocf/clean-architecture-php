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

    public function execute(string $query)
    {
        $statement = $this->connection->execute($query);

        return $statement->fetchAll(StatementInterface::FETCH_TYPE_OBJ);
    }

    public function select(string $table, array $fields, array $conditions): array
    {
        $query = $this->connection->newQuery();
        $query->select($fields)
            ->from($table)
            ->where($conditions);

        return $query->execute()->fetchAll(StatementInterface::FETCH_TYPE_OBJ) ?? [];
    }

    public function insert(string $table, array $data): bool
    {
        return false;
    }

    public function update(string $table, array $data, array $conditions): bool
    {
        $statement = $this->connection->update($table, $data, $conditions);

        return $statement->rowCount() > 0;
    }

    public function delete(array $conditions): bool
    {
        return false;
    }
}
