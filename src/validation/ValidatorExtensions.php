<?php

namespace MadeITBelgium\EmailDomainValidation\Validation;

class ValidatorExtensions
{
    /**
     * @var MadeITBelgium\EmailDomainValidation\Validation\Validator
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validateDomain($attribute, $value, $parameters)
    {
        return $this->validator->isEmailAllowed($value, $parameters);
    }

    public function validateDomainnot($attribute, $value, $parameters)
    {
        return $this->validator->isEmailNotAllowed($value, $parameters);
    }
}
