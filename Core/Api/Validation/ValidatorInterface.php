<?php

namespace Core\Api\Validation;

/**
 * Interface ValidatorInterface
 * @package Core\Api\Validation
 */
interface ValidatorInterface
{
    /**
     * Validate request data
     *
     * @param array $data
     * @param array $rules
     * @return void
     */
    public function validate(array $data, array $rules = []): void;

    /**
     * Get errors of request validation
     *
     * @return array
     */
    public function errors(): array;
}
