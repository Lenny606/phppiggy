<?php
declare(strict_types=1);

namespace App\Services;

use Framework\Rules\EmailRule;
use Framework\Rules\InRule;
use Framework\Rules\MatchRule;
use Framework\Rules\MinAgeRule;
use Framework\Rules\UrlRule;
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
        $this->validator->add('email', new EmailRule());
        $this->validator->add('minAge', new MinAgeRule());
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new UrlRule());
        $this->validator->add('match', new MatchRule());

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
            'email' => ['required', 'email'],
            'age' => ['required', "min:18"],//custom rule : parameter
            'country' => ['required', "in:USA,Canada,Mexico"],
            'social_media_url' => ['required', 'url'],
            'password' => ['required'],
            'confirm_password' => ['required', 'match:password'], //field as parameter
            'terms_of_service' => ['required'],
        ]);
    }
}