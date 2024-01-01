<?php
declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\RequiredRule;


//provides data (what) for Validator class in Framework (how)
class ValidatorService
{
    //no need for DI, only this service need that validator class
    //instance in constructor via old way
    private Validator $validator;


    public function __construct()
    {
        $this->validator = new Validator();

        //store required validator rule
        $this->validator->add('required', new RequiredRule());
    }

    /**
     * @param array $formData
     *
     */
    public function validateRegister(array $formData)
    {
        //dont validate entire form data, better field by field
        //validation is in Validator class
        $this->validator->validate($formData, [
            'email' => ['required'],
            'age' => ['required'],
            'country' => ['required'],
            'social_media_url' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['required'],
            'terms_of_service' => ['required'],
        ]);
    }
}