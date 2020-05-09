<?php

namespace Core\Api\Database\Connection;

use Core\Api\Database\QueryBuilder\MySqlQueryBuilderInterface;

/**
 * Interface ConnectionInterface
 */
interface MySqlConnectionInterface
{
    /**
     * Connection to database via PDO
     *
     * @param string $driver
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     * @return void
     */
    public function connection($driver, $host, $database, $username, $password): void;

    /**
     * Get QueryBuilder
     *
     * @return MySqlQueryBuilderInterface
     */
    public function query(): object;
}
