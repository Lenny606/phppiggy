<?php
declare(strict_types=1);

namespace App\Services;

use Framework\Validator;


//provides data (what) for Validator class in Framework (how)
class ValidatorService
{
    //no need for DI, only this service need that validator class
    //instance in constructor via old way
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * @param array $formData
     * @return void
     */
    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData);
    }
}