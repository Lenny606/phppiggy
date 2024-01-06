<?php
declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class EmailRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        //filter_var function to validate email + type casting
        return (bool)filter_var($data[$field], FILTER_VALIDATE_EMAIL);
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "Invalid email";
    }
}