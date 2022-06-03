<?php

namespace App\External\Persistence;

use Cake\Database\Connection;
use Cake\Database\StatementInterface;
use Cake\Datasource\ConnectionManager;

class MysqlDatabase implements DatabaseInterface
{

    private Connection $connection;

    public function __construct()
    {
        $this->connection = ConnectionManager::get('default');
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
    public function select(string $table, array $fields, array $conditions, int $start = 0, int $offset = 10): array
    {
        $query = $this->connection->newQuery();
        $query->select($fields)
            ->from($table)
            ->where($conditions)
            ->offset($start)
            ->limit($offset);

        return $query->execute()->fetchAll(StatementInterface::FETCH_TYPE_OBJ) ?? [];
    }

    /**
     * @inheritdoc
     */
    public function count(string $table): int
    {
        $query = $this->connection->newQuery();
        $query
            ->select($query->func()->count('*'))
            ->from($table);

        return $query->execute()->fetchColumn(0);
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
