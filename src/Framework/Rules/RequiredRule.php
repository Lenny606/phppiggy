<?php
declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

//General rules, can be setup in Framework
//more specific rules register in App
class RequiredRule implements RuleInterface
{
    /**
     * check if field is not empty
     * @param array $data data from entire form
     * @param string $field one field
     * @param array $params
     * @return bool
     */
    public function validate(array $data, string $field, array $params): bool
    {
        return !empty($data[$field]);
    }

    //error message if validation fails
    public function getMessage(array $data, string $field, array $params): string
    {
        return "This field ,,${$field},, is required";
    }

}