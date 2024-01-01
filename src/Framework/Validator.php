<?php
declare(strict_types=1);

namespace Framework;

//validator class in Framework tells App how to use it,
// but data what is validated are responsibility of the application

//Validator class is not needed to be instantiated globally, only for one service -> that why no container regisration
class Validator
{

    public function validate(array $formData)
    {

    }
}