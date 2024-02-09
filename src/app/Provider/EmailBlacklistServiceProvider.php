<?php

namespace FireLab\App\Provider;

use FireLab\App\Command\BlacklistsUpdateCommand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class EmailBlacklistServiceProvider extends ServiceProvider
{

    public function boot(): void
    {

        $this->loadJSONTranslationsFrom(__DIR__.'/../../../lang', 'firelab.domains.blacklist');

        $this->publishes([
            __DIR__.'/../../../lang' => resource_path('lang/vendor/email-domain-blacklist'),
        ]);

        $this->publishConfig();

        Validator::extend('email-blacklist', "FireLab/App/Validator@validate");
        Validator::replacer('email-blacklist', "FireLab/App/Validator@message");
    }

    public function register()
    {
        $this->mergeConfig();
        $this->app->bind('firelab.command:update-blacklists', BlacklistsUpdateCommand::class);

        $this->commands(['firelab.command:update-blacklists']);
    }

    private function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('firelab.php')], 'config');
    }

    private function getConfigPath(): string
    {
        return __DIR__.'/../../../config/firelab.php';
    }

    private function mergeConfig()
    {
        $path = $this->getConfigPath();
        $this->mergeConfigFrom($path, 'firelab');
    }
}
