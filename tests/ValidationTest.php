<?php

use Illuminate\Validation\Factory;
use MadeITBelgium\EmailDomainValidation\Validation\Validator;
use MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions;
use PHPUnit\Framework\TestCase;

class validateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testValidatorDomain()
    {
        $validator = new Validator();
        $this->assertTrue($validator->isEmailAllowed('info@madeit.be', ['madeit.be']));
        $this->assertFalse($validator->isEmailAllowed('info@notmadeit.be', ['madeit.be']));
    }

    public function testValidatorNotInDomain()
    {
        $validator = new Validator();
        $this->assertTrue($validator->isEmailNotAllowed('info@madeit.be', ['example.be']));
    }

    public function testValidEmail()
    {
        $validator = Mockery::mock('MadeITBelgium\EmailDomainValidation\Validation\Validator');
        $extensions = new ValidatorExtensions($validator);
        $container = Mockery::mock('Illuminate\Container\Container');
        $translator = Mockery::mock('Illuminate\Contracts\Translation\Translator');
        $container->shouldReceive('make')->once()->with('MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions')->andReturn($extensions);
        $validator->shouldReceive('isEmailAllowed')->once()->with('info@madeit.be', ['madeit.be'])->andReturn(true);
        $factory = new Factory($translator, $container);
        $factory->extend('domain', 'MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions@validateDomain', 'The domain of :attribute is not allowed');
        $validator = $factory->make(['foo' => 'info@madeit.be'], ['foo' => 'domain:madeit.be']);
        $this->assertTrue($validator->passes());
    }

    public function testValidEmailFails()
    {
        $validator = Mockery::mock('MadeITBelgium\EmailDomainValidation\Validation\Validator');
        $extensions = new ValidatorExtensions($validator);
        $container = Mockery::mock('Illuminate\Container\Container');
        $translator = Mockery::mock('Illuminate\Contracts\Translation\Translator');
        $container->shouldReceive('make')->once()->with('MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions')->andReturn($extensions);
        $validator->shouldReceive('isEmailAllowed')->once()->with('info@madeit.be', ['example.be'])->andReturn(false);
        $translator->shouldReceive('get')->once()->with('validation.custom')->andReturn('validation.custom');
        $translator->shouldReceive('get')->once()->with('validation.custom.foo.domain')->andReturn('validation.custom.foo.domain');
        $translator->shouldReceive('get')->once()->with('validation.domain')->andReturn('validation.domain');
        $translator->shouldReceive('get')->once()->with('validation.attributes')->andReturn('validation.attributes');
        $translator->shouldReceive('get')->once()->with('validation.values.foo.info@madeit.be')->andReturn('validation.values.foo.info@madeit.be');
        
        $factory = new Factory($translator, $container);
        $factory->extend('domain', 'MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions@validateDomain', 'The domain of :attribute is not allowed');
        $validator = $factory->make(['foo' => 'info@madeit.be'], ['foo' => 'domain:example.be']);
        $this->assertTrue($validator->fails());
        $messages = $validator->messages();
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $messages);
        $this->assertEquals('The domain of foo is not allowed', $messages->first('foo'));
    }

    public function testValidEmailNotAllowed()
    {
        $validator = Mockery::mock('MadeITBelgium\EmailDomainValidation\Validation\Validator');
        $extensions = new ValidatorExtensions($validator);
        $container = Mockery::mock('Illuminate\Container\Container');
        $translator = Mockery::mock('Illuminate\Contracts\Translation\Translator');
        $container->shouldReceive('make')->once()->with('MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions')->andReturn($extensions);
        $validator->shouldReceive('isEmailNotAllowed')->once()->with('info@madeit.be', ['tpweb.org'])->andReturn(true);
        $factory = new Factory($translator, $container);
        $factory->extend('domainnot', 'MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions@validateDomainnot', 'the domain of :attribute is not allowed');
        $validator = $factory->make(['foo' => 'info@madeit.be'], ['foo' => 'domainnot:tpweb.org']);
        $this->assertTrue($validator->passes());
    }

    public function testValidEmailNotAllowedFails()
    {
        $validator = Mockery::mock('MadeITBelgium\EmailDomainValidation\Validation\Validator');
        $extensions = new ValidatorExtensions($validator);
        $container = Mockery::mock('Illuminate\Container\Container');
        $translator = Mockery::mock('Illuminate\Contracts\Translation\Translator');
        $container->shouldReceive('make')->once()->with('MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions')->andReturn($extensions);
        $validator->shouldReceive('isEmailNotAllowed')->once()->with('info@madeit.be', ['madeit.be'])->andReturn(false);
        $translator->shouldReceive('get')->once()->with('validation.custom')->andReturn('validation.custom');
        $translator->shouldReceive('get')->once()->with('validation.custom.foo.domainnot')->andReturn('validation.custom.foo.domainnot');
        $translator->shouldReceive('get')->once()->with('validation.domainnot')->andReturn('validation.domainnot');
        $translator->shouldReceive('get')->once()->with('validation.attributes')->andReturn('validation.attributes');
        $translator->shouldReceive('get')->once()->with('validation.values.foo.info@madeit.be')->andReturn('validation.values.foo.info@madeit.be');
        
        $factory = new Factory($translator, $container);
        $factory->extend('domainnot', 'MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions@validateDomainnot', 'The domain of :attribute is not allowed');
        $validator = $factory->make(['foo' => 'info@madeit.be'], ['foo' => 'domainnot:madeit.be']);
        $this->assertTrue($validator->fails());
        $messages = $validator->messages();
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $messages);
        $this->assertEquals('The domain of foo is not allowed', $messages->first('foo'));
    }
}
