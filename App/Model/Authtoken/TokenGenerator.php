<?php

namespace App\Model\Authtoken;

use App\Api\Authtoken\TokenGeneratorInterface;

/**
 * Class TokenGenerator
 * @package App\Model\AuthToken
 */
class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * Generate token
     *
     * @param int $key
     * @return string
     * @throws \Exception
     */
    public function generateToken(int $key): string
    {
        return bin2hex(random_bytes($key));
    }
}
