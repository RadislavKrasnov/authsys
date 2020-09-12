<?php

namespace App\Api\Authtoken;

/**
 * Interface TokenGeneratorInterface
 * @package App\Api\Authtoken
 */
interface TokenGeneratorInterface
{
    /**
     * Generate token
     *
     * @param int $key
     * @return string
     * @throws \Exception
     */
    public function generateToken(int $key): string;
}
