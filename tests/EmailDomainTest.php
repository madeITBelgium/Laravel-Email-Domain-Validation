<?php
use MadeITBelgium\EmailDomainValidation\EmailDomain;
class EmailDomainTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testConstructor()
    {
        $emailDomain = new EmailDomain();
        $this->assertEquals(null, $emailDomain->getEmail());
        $this->assertEquals(null, $emailDomain->getAllowedDomains());
        $this->assertEquals(null, $emailDomain->getNotAllowedDomains());
    
        $emailDomain = new EmailDomain('info@madeit.be', ['madeit.be'], ['tpweb.org']);
        $this->assertEquals("info@madeit.be", $emailDomain->getEmail());
        $this->assertEquals(['madeit.be'], $emailDomain->getAllowedDomains());
        $this->assertEquals(['tpweb.org'], $emailDomain->getNotAllowedDomains());
    }
    
    public function testEmail() 
    {
        $emailDomain = new EmailDomain();
        $emailDomain->setEmail(null);
        $this->assertEquals(null, $emailDomain->getEmail());
        
        
        $emailDomain->setEmail('info@madeit.be');
        $this->assertEquals('info@madeit.be', $emailDomain->getEmail());
    }
    
    public function testAllowedDomains() 
    {
        $emailDomain = new EmailDomain();
        $emailDomain->setAllowedDomains(null);
        $this->assertEquals(null, $emailDomain->getAllowedDomains());
        
        
        $emailDomain->setAllowedDomains('madeit.be', 'tpweb.org');
        $this->assertEquals(['madeit.be', 'tpweb.org'], $emailDomain->getAllowedDomains());
    }
    
    public function testNotAllowedDomains() 
    {
        $emailDomain = new EmailDomain();
        $emailDomain->setNotAllowedDomains(null);
        $this->assertEquals(null, $emailDomain->getNotAllowedDomains());
        
        
        $emailDomain->setNotAllowedDomains('madeit.be', 'tpweb.org');
        $this->assertEquals(['madeit.be', 'tpweb.org'], $emailDomain->getNotAllowedDomains());
    }
    
    public function providerValidEmails()
    {
        return [
            ['email@example.com'],
            ['firstname.lastname@example.com'],
            ['email@subdomain.example.com'],
            ['firstname+lastname@example.com'],
            ['"email"@example.com'],
            ['1234567890@example.com'],
            ['email@example-one.com'],
            ['_______@example.com'],
            ['email@example.name'],
            ['email@example.museum'],
            ['email@example.co.jp'],
            ['firstname-lastname@example.com'],
        ];
    }
    
    /**
    * This is kind of a smoke test
    *
    * @dataProvider providerValidEmails
    **/
    public function testValidEmails($email)
    {
        $emailDomain = new EmailDomain();
        $emailDomain->setEmail($email);
        $this->assertEquals($email, $emailDomain->getEmail());
        $this->assertEquals(true, $emailDomain->isEmailValid());
        
        $emailDomain->setEmail(null);
        
        $this->assertEquals(true, $emailDomain->isEmailValid($email));
        $this->assertEquals($email, $emailDomain->getEmail());
    }
    
    public function providerInValidEmails()
    {
        return [
            ['plainaddress'], 
            ['#@%^%#$@#$@#.com'], 
            ['@example.com'], 
            ['Joe Smith <email@example.com>'], 
            ['email.example.com'], 
            ['email@example@example.com'], 
            ['.email@example.com'], 
            ['email.@example.com'], 
            ['email..email@example.com'], 
            ['あいうえお@example.com'], 
            ['email@example.com (Joe Smith)'], 
            ['email@example'], 
            ['email@-example.com'], 
            ['email@111.222.333.44444'], 
            ['email@example..com'], 
            ['Abc..123@example.com'],
        ];
    }
    
    /**
    * This is kind of a smoke test
    *
    * @dataProvider providerInValidEmails
    **/
    public function testInValidEmails($email)
    {
        $emailDomain = new EmailDomain();
        $emailDomain->setEmail($email);
        $this->assertEquals($email, $emailDomain->getEmail());
        $this->assertEquals(false, $emailDomain->isEmailValid());
        
        $emailDomain->setEmail(null);
        
        $this->assertEquals(false, $emailDomain->isEmailValid($email));
        $this->assertEquals($email, $emailDomain->getEmail());
    }
    
    public function providerValidDomains()
    {
        return [
            ['example.com'],
            ['a'],
            ['a.b'],
            ['localhost'],
            ['google.com'],
            ['news.google.co.uk'],
            ['xn--fsqu00a.xn--0zwm56d'],
        ];
    }
    
    /**
    * This is kind of a smoke test
    *
    * @dataProvider providerValidDomains
    **/
    public function testValidDomains($domain)
    {
        $emailDomain = new EmailDomain();
        $emailDomain->setAllowedDomains($domain);
        $this->assertEquals([$domain], $emailDomain->getAllowedDomains());
        $this->assertEquals(true, $emailDomain->areAllowedDomainsValid());
        
        $emailDomain->setAllowedDomains(null);
        
        $this->assertEquals(true, $emailDomain->areAllowedDomainsValid($domain));
        $this->assertEquals([$domain], $emailDomain->getAllowedDomains());
        
        
        $emailDomain->setNotAllowedDomains($domain);
        $this->assertEquals([$domain], $emailDomain->getNotAllowedDomains());
        $this->assertEquals(true, $emailDomain->areNotAllowedDomainsValid());
        
        $emailDomain->setNotAllowedDomains(null);
        
        $this->assertEquals(true, $emailDomain->areNotAllowedDomainsValid($domain));
        $this->assertEquals([$domain], $emailDomain->getNotAllowedDomains());
    }
    
    
    public function providerInValidDomains()
    {
        return [
            ['goo gle.com'],
            ['google..com'],
            ['google.com '],
            ['google-.com'],
            ['.google.com'],
            ['<script'],
            ['alert('],
            ['.'],
            ['..'],
            [' '],
            ['-'],
        ];
    }
    
    /**
    * This is kind of a smoke test
    *
    * @dataProvider providerInValidDomains
    **/
    public function testInValidDomains($domain)
    {
        $emailDomain = new EmailDomain();
        $emailDomain->setAllowedDomains($domain);
        $this->assertEquals([$domain], $emailDomain->getAllowedDomains());
        $this->assertEquals(false, $emailDomain->areAllowedDomainsValid());
        
        $emailDomain->setAllowedDomains(null);
        
        $this->assertEquals(false, $emailDomain->areAllowedDomainsValid($domain));
        $this->assertEquals([$domain], $emailDomain->getAllowedDomains());

        
        
        $emailDomain->setNotAllowedDomains($domain);
        $this->assertEquals([$domain], $emailDomain->getNotAllowedDomains());
        $this->assertEquals(false, $emailDomain->areNotAllowedDomainsValid());
        
        $emailDomain->setNotAllowedDomains(null);
        
        $this->assertEquals(false, $emailDomain->areNotAllowedDomainsValid($domain));
        $this->assertEquals([$domain], $emailDomain->getNotAllowedDomains());
    }
    
    public function testEmailIsAllowed() {
        $emailDomain = new EmailDomain('info@madeit.be', ['madeit.be'], ['example.com']);
        $this->assertEquals(true, $emailDomain->isEmailAllowed());

        $emailDomain = new EmailDomain('info@madeit.be', null, ['example.com']);
        $this->assertEquals(true, $emailDomain->isEmailAllowed());
        
        $emailDomain = new EmailDomain('info@madeit.be', ['madeit.be'], null);
        $this->assertEquals(true, $emailDomain->isEmailAllowed());
        
        $this->assertEquals(true, $emailDomain->isEmailAllowed('tjebbe.lievens@madeit.be', ['madeit.be'], ['example.com']));
        
        
        $this->assertEquals(true, $emailDomain->checkEmailIsAllowedInDomains('tjebbe.lievens@madeit.be', ['madeit.be']));
        $this->assertEquals(false, $emailDomain->checkEmailIsNotAllowedInDomains('tjebbe.lievens@madeit.be', ['example.be']));
    }
    
    
    public function testEmailIsNotAllowed() {
        $emailDomain = new EmailDomain('info@example.com', ['madeit.be'], ['example.com']);
        $this->assertEquals(false, $emailDomain->isEmailAllowed());

        $emailDomain = new EmailDomain('info@example.com', null, ['example.com']);
        $this->assertEquals(false, $emailDomain->isEmailAllowed());
        
        $emailDomain = new EmailDomain('info@example.com', ['madeit.be'], null);
        $this->assertEquals(false, $emailDomain->isEmailAllowed());
    }
}