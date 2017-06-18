<?php

use MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions;
use MadeITBelgium\EmailDomainValidation\Validation\Validator;
use Illuminate\Validation\Factory;

class validateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testValidatorDomain() {
        $validator = new Validator;
        $this->assertTrue($validator->isEmailAllowed("info@madeit.be", ['madeit.be']));
    }
    
    public function testValidatorNotInDomain() {
        $validator = new Validator;
        $this->assertTrue($validator->isEmailNotAllowed("info@madeit.be", ['example.be']));
    }
    
    /*
    public function testValidIban()
    {
        $validator = Mockery::mock('MadeITBelgium\EmailDomainValidation\Validation\Validator');
        $extensions = new ValidatorExtensions($validator);
        $container = Mockery::mock('Illuminate\Container\Container');
        $translator = Mockery::mock('Symfony\Component\Translation\TranslatorInterface');
        $container->shouldReceive('make')->once()->with('MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions')->andReturn($extensions);
        $validator->shouldReceive('validateDomain')->once()->with('info@madeit.be')->andReturn(true);
        $factory = new Factory($translator, $container);
        $factory->extend('emaildomain', 'MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions@validateDomain', 'the domain of :attribute is not allowed');
        $validator = $factory->make(['foo' => 'info@madeit.be'], ['foo' => 'emaildomain']);
        $this->assertTrue($validator->passes());
    }*/
    
}