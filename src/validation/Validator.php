<?php

namespace MadeITBelgium\EmailDomainValidation\Validation;

use MadeITBelgium\EmailDomainValidation\EmailDomain;

class Validator
{
	public function isEmailAllowed($email, $domains)
	{
        $emailDomain = new EmailDomain($email, $domains);
        return $emailDomain->isEmailAllowed();
	}
    
	public function isEmailNotAllowed($email, $domains)
	{
        $emailDomain = new EmailDomain($email, null, $domains);
        return $emailDomain->isEmailAllowed();
	}
}