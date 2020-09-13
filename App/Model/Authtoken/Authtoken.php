<?php

namespace App\Model\Authtoken;

use App\Api\Authtoken\AuthtokenInterface;
use Core\ActiveRecord\Model;

/**
 * Class Authtoken
 * @package App\Model
 */
class Authtoken extends Model implements AuthtokenInterface
{
    /**
     * @var string
     */
    protected $table = 'authentication_token';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'password_hash',
        'selector_hash',
        'is_expired',
        'expiry_date'
    ];

    /**
     * Get token by email
     *
     * @param string $email
     * @param int $isExpired
     * @return AuthtokenInterface|null
     */
    public function getTokenByEmail(string $email, int $isExpired): ?object
    {
        $token = $this->select()->where([
            ['email', '=', $email],
            ['is_expired', '=', $isExpired]
        ])->first();

        if (!$token) {
            return null;
        }

        return $token;
    }
}
