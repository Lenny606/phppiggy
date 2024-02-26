<?php
declare(strict_types=1);

namespace App\Services;

use Framework\Rules\DateFormatRule;
use Framework\Rules\EmailRule;
use Framework\Rules\InRule;
use Framework\Rules\LengthMaxRule;
use Framework\Rules\MatchRule;
use Framework\Rules\MinAgeRule;
use Framework\Rules\NumericRule;
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
        $this->validator->add('lengthMax', new LengthMaxRule());
        $this->validator->add('numeric', new NumericRule());
        $this->validator->add('date', new DateFormatRule());

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
        //    'age' => ['required', "min:18"],//custom rule : parameter
            'country' => ['required', "in:USA,Canada,Mexico"],
            'social_media_url' => ['required', 'url'],
            'password' => ['required'],
            'confirm_pasword' => ['required', 'match:password'], //field as parameter
            'terms_of_service' => ['required'],
        ]);
    }

    public function validateLogin(array $formData) : void
    {
        //dont validate entire form data, better field by field
        //validation is in Validator class
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    }

    public function validateTransaction(array $formData) : void
    {
        $this->validator->validate($formData, [
            'description' => ['required', 'lengthMax:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date:Y-m-d']
        ]);
    }
}