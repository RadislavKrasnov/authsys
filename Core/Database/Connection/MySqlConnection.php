<?php

namespace Core\Database\Connection;

use Core\Database\Connection;
use Core\Api\Database\Connection\MySqlConnectionInterface;
use Core\Api\Database\QueryBuilder\MySqlQueryBuilderInterface;

/**
 * Class MySqlConnection
 *
 * @package Core\Database\Connection
 */
class MySqlConnection extends Connection implements MySqlConnectionInterface
{
    /**
     * @var MySqlQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * MySqlConnection constructor.
     *
     * @param MySqlQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        MySqlQueryBuilderInterface $queryBuilder
    ) {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Get QueryBuilder
     *
     * @return MySqlQueryBuilderInterface
     */
    public function query(): object
    {
        $this->queryBuilder->setPdo($this->pdo);

        return $this->queryBuilder;
    }
}
