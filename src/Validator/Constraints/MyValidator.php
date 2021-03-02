<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

class MyValidator
{
    public function notBlank($value, $field)
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($value, new NotBlank());
        if (!empty(count($violations))) {
            return "Le '$field' doit être renseigné!";
        }
    }
}
