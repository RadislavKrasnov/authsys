<?php

namespace Core\Config;

use Core\Api\Config\DevelopmentConfigInterface;

/**
 * Class DevelopmentConfig
 * @package Core\Model\Config
 */
class DevelopmentConfig implements DevelopmentConfigInterface
{
    /**
     * Get configuration from config file
     *
     * @param string $key
     * @param string $configFile
     * @return array|string|null
     * @throws \Exception
     */
    public function get(string $key, string $configFile = DevelopmentConfigInterface::ENV_FILE)
    {
        $result = [];

        if (empty($key)) {
            return $result;
        }

        $result = $this->loadConfigFile($configFile);
        $configElements = explode('/', $key);

        foreach ($configElements as $configElement) {
            $result = $result[$configElement];
        }

        return $result;
    }

    /**
     *  Load configuration file
     *
     * @param string $filepath
     * @return array
     * @throws \Exception
     */
    public function loadConfigFile(string $filepath): array
    {
        $result = [];

        if (!file_exists($filepath)) {
            throw new \Exception('Warning! '. $filepath . ' was not found!');
        }

        $result = include $filepath;

        return $result;
    }
}
