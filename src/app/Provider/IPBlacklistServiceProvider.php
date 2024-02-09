<?php

namespace FireLab\App\Provider;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class IPBlacklistServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Validator::extend('ip-blacklist', "FireLab/App/Validator@validate");
        Validator::replacer('ip-blacklist', "FireLab/App/Validator@message");
    }
}