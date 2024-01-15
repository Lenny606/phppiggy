<?php
declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

//validator class in Framework tells App how to use it,
// but data what is validated are responsibility of the application

//Validator class is not needed to be instantiated globally, only for one service -> that why no container regisration


class Validator
{
    //stored rules parameters
    private array $rulesPa = [];
    //stored validation rules
    private array $rules = [];

    /**
     * adding new rules
     * @param string $alias identifier for different validation rules
     * @param RuleInterface $rule object what implements this interface
     * @return void
     */
    public function add(string $alias, RuleInterface $rule): void
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $formData, array $fields)
    {
        //stored validation errors
        $errors = [];
        //validation for one field in each time
        //rules is [] array with multiple rules
        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {

                //check if rule has parameters with ,:,
                if(str_contains($rule, ':'))
                {   //deconstruct
                    [$rule, $ruleParam]= explode(":", $rule);
                    $ruleParam = explode(',', $ruleParam);
                }

                //grabbing rule alias from array of stored rules and save in variable
                $ruleValidator = $this->rules[$rule];

                //run validation condition
                if ($ruleValidator->validate($formData, $fieldName, $ruleParam)) {
                    continue;
                    //TODO remove else block if some errors happened
                } else {
                    //store error in multidimensional array for each field in loop
                    //error are handled by middleware
                    $errors[$fieldName][] = $ruleValidator->getMessage($formData, $fieldName);
                }
            }
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}