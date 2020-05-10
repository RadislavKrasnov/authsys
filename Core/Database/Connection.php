<?php

namespace Core\Database;

/**
 * Class Connection
 *
 * @package Core\Database
 */
class Connection
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Connection to database via PDO
     *
     * @param string $driver
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     * @return Connection
     */
    public function connection($driver, $host, $database, $username, $password): object
    {
        try {
            $this->pdo = new \PDO(
                "$driver:host=$host;dbname=$database",
                $username,
                $password
            );

            return $this;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
        }
    }
}
