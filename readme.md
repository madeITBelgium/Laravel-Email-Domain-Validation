# PHP Laravel E-mail domain validator

[![Build Status](https://travis-ci.org/madeITBelgium/Laravel-Email-Domain-Validation.svg?branch=master)](https://travis-ci.org/madeITBelgium/Laravel-Email-Domain-Validation)
[![Coverage Status](https://coveralls.io/repos/github/madeITBelgium/Laravel-Email-Domain-Validation/badge.svg?branch=master)](https://coveralls.io/github/madeITBelgium/Laravel-Email-Domain-Validation?branch=master)
[![Latest Stable Version](https://poser.pugx.org/madeITBelgium/Laravel-Email-Domain-Validation/v/stable.svg)](https://packagist.org/packages/madeITBelgium/Laravel-Email-Domain-Validation)
[![Latest Unstable Version](https://poser.pugx.org/madeITBelgium/Laravel-Email-Domain-Validation/v/unstable.svg)](https://packagist.org/packages/madeITBelgium/Laravel-Email-Domain-Validation)
[![Total Downloads](https://poser.pugx.org/madeITBelgium/Laravel-Email-Domain-Validation/d/total.svg)](https://packagist.org/packages/madeITBelgium/Laravel-Email-Domain-Validation)
[![License](https://poser.pugx.org/madeITBelgium/Laravel-Email-Domain-Validation/license.svg)](https://packagist.org/packages/madeITBelgium/Laravel-Email-Domain-Validation)

With this Laravel package you can validate email input that it contains or not contains a specific domainname. This is useful to create a registration to restrict registrions for the company email domain.

# Installation

Require this package in your `composer.json` and update composer.

```php
"madeitbelgium/laravel-email-domain-validation": "~1.0"
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
MadeITBelgium\EmailDomainValidation\EmailDomainServiceProvider::class,
```

You can use the facade for shorter code. Add this to your aliases:

```php
'EmailDomainValidation' => TPWeb\EmailDomainValidation\EmailDomainFacade::class,
```

# Documentation

## Usage

```php
$emailDomain = new EmailDomain('info@madeit.be', ['madeit.be'], ['tpweb.org']);
$emailDomain->isEmailValid() //Checks if the given e-mail address is valid
$emailDomain->areAllowedDomainsValid(); //Check if the given allowed domains are valid
$emailDomain->areNotAllowedDomainsValid()


$emailDomain->isEmailAllowed() //Check if the email address is allowed.
$emailDomain->isEmailAllowed('info@madeit.be', ['madeit.be'], ['example.com']));
```

## Laravel validator

```php
public function store(Request $request) {
    $this->validate($request, ['email' => 'required|email|domain:madeit.be,hotmail.com|domainnot:gmail.com,yahoo.com']);
}
```

The complete documentation can be found at: [http://www.madeit.be/](http://www.madeit.be/)

# Support

Support github or mail: tjebbe.lievens@madeit.be

# Contributing

Please try to follow the psr-2 coding style guide. http://www.php-fig.org/psr/psr-2/

# License

This package is licensed under LGPL. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!
