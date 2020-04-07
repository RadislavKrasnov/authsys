<?php

namespace Core\Api;

/**
 * Interface BootstrapInterface
 * @package Core\Api
 */
interface BootstrapInterface
{
    /**
     * Run bootstrap (Front Controller)
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void;
}
