<?php

namespace MadeITBelgium\EmailDomainValidation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * Laravel Email Domain validator.
 *
 * @version    1.0.0
 *
 * @copyright  Copyright (c) 2017 Made I.T. (http://www.madeit.be)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class EmailDomainServiceProvider extends ServiceProvider
{
    protected $defer = false;
    protected $rules = [
        'domain', 'domainnot',
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'emaildomain');
        $this->addNewRules();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('emaildomain', 'MadeITBelgium\EmailDomainValidation');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['emaildomain'];
    }

    protected function addNewRules()
    {
        foreach ($this->rules as $rule) {
            $this->extendValidator($rule);
        }
    }

    protected function extendValidator($rule)
    {
        $method = 'validate'.Str::studly($rule);

        Validator::extend($rule, 'MadeITBelgium\EmailDomainValidation\Validation\ValidatorExtensions@'.$method);
    }
}
