<?php
declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class MatchRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        $fieldOne = $data[$field];
        $fieldTwo = $data[$params[0]];

        return $fieldTwo === $fieldOne;
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "Doesnt match {$params[0]} field";
    }
}