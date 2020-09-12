<?php

namespace App\Api\Authtoken;

/**
 * Interface AuthtokenInterface
 * @package App\Api\Authtoken
 */
interface AuthtokenInterface
{
    /**
     * Get token by email
     *
     * @param string $email
     * @param int $isExpired
     * @return AuthtokenInterface|null
     */
    public function getTokenByEmail(string $email, int $isExpired): ?object;
}
