<?php

namespace Core\Database;

use Core\Api\Config\DevelopmentConfigInterface;
use Core\Api\Database\Connection\MySqlConnectionInterface;

/**
 * Class ConnectionResolver
 *
 * @package Core\Database
 */
class ConnectionResolver
{
    /**
     * @var array
     */
    private static $connections = [];

    /**
     * Initialize connections
     *
     * @param DevelopmentConfigInterface $developmentConfig
     * @param MySqlConnectionInterface $mySqlConnection
     * @return bool|void
     */
    public static function initializeConnections(
        DevelopmentConfigInterface $developmentConfig,
        MySqlConnectionInterface $mySqlConnection

    ) {
        if(!($developmentConfig instanceof DevelopmentConfigInterface)) {
            return false;
        }

        $configurations = $developmentConfig->get('databases');

        if (empty($configurations)) {
            return false;
        }

        try {
            $connection = null;
            foreach ($configurations as $name => $configuration) {
                switch ($configuration['driver']) {
                    case 'mysql':
                        $connection = $mySqlConnection->connection(
                            $configuration['driver'],
                            $configuration['host'],
                            $configuration['dbname'],
                            $configuration['username'],
                            $configuration['password']
                        );
                        break;
                }
                self::addConnection($name, $connection);
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * Add connection
     *
     * @param string $name
     * @param MySqlConnectionInterface $connection
     */
    public static function addConnection($name, $connection)
    {
        self::$connections[$name] = $connection;
    }

    /**
     * Get connection
     *
     * @param string $name
     * @return MySqlConnectionInterface
     * @throws \InvalidArgumentException
     */
    public static function getConnection($name)
    {
        if (!array_key_exists($name, self::$connections)) {
            throw new \InvalidArgumentException('The element with index ' . $name . ' doesn\'t exist.');
        }

        return self::$connections[$name];
    }
}
