<?php

namespace Core\Api\Config;

/**
 * Interface DevelopmentConfigInterface
 * @package Core\Api\Config
 */
interface DevelopmentConfigInterface
{
    const CONFIG_FOLDER = '../etc/env.php';

    /**
     * Get configuration from config file
     *
     * @param string $key
     * @param string $configFile
     * @return array|string|null
     * @throws \Exception
     */
    public function get(string $key, string $configFile);

    /**
     * Load configuration file
     *
     * @param string $filepath
     * @return array
     * @throws \Exception
     */
    public function loadConfigFile(string $filepath): array;
}
