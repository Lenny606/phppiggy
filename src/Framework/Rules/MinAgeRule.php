<?php
declare(strict_types=1);
namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use http\Exception\InvalidArgumentException;

class MinAgeRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if(empty($params[0])){
            throw new InvalidArgumentException("Min length not specified");
        }

        $length = (int) $params[0]; // 18
        return $data[$field] >= $length;
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "Must be greater or equal to {$params[0]}";
    }
}