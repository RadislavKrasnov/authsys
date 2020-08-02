<?php

namespace Core\Validation;

use Core\Api\Validation\ValidatorInterface;

/**
 * Class Validator
 */
class Validator implements ValidatorInterface
{
    /**
     * Errors of request validation
     *
     * @var array
     */
    private $errors = [];

    /**
     * Validate request data
     *
     * @param array $data
     * @param array $rules
     */
    public function validate(array $data, array $rules = []): void
    {
        foreach ($data as $item => $itemValue) {
            if (!array_key_exists($item, $rules)) {
                continue;
            }

            foreach ($rules[$item] as $rule => $ruleValue) {

                if (is_int($rule)) {
                    $rule = $ruleValue;
                }

                switch ($rule) {
                    case 'required':
                        if (empty($itemValue)) {
                            $this->addError($item, ucwords($item) . ' required');
                        }
                        break;
                    case 'alphanumeric':
                        $pattern = '/[a-zA-Z0-9]+/i';
                        if (!preg_match($pattern, $itemValue)) {
                            $this->addError($item, ucwords($item) . ' should contain only alphabetic characters and numeric');
                        }
                        break;
                    case 'email':
                        $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/';
                        if (!preg_match($pattern, $itemValue)) {
                            $this->addError($item, ucwords($item) . ' ins\'t valid');
                        }
                        break;
                    case 'password':
                        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,}$/';
                        if (!preg_match($pattern, $itemValue)) {
                            $this->addError($item,
                                ucwords($item) . ' should contain at least one lowercase and uppercase letter, one number, one specific character and have at least 8 characters'
                            );
                        }
                        break;
                    case 'usa_date_format':
                        $pattern = '/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/';
                        if (!preg_match($pattern, $itemValue)) {
                            $this->addError($item,
                                ucwords($item) . ' should be in MM/DD/YYYY format'
                            );
                        }
                        break;
                    case 'numeric':
                        $pattern = '/[0-9]+/';
                        if (!preg_match($pattern, $itemValue)) {
                            $this->addError($item,
                                ucwords($item) . ' should be numeric'
                            );
                        }
                }
            }
        }
    }

    /**
     * Add validation error message
     *
     * @param string $item
     * @param string $error
     */
    private function addError(string $item, string $error): void
    {
        $this->errors[$item][] = $error;
    }

    /**
     * Get errors of request validation
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
