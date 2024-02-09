<?php

namespace FireLab\App\Provider;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class DomainBlacklistServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Validator::extend('domain-blacklist', "FireLab/App/Validator@validate");
        Validator::replacer('domain-blacklist', "FireLab/App/Validator@message");
    }
}
