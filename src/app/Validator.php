<?php

namespace FireLab\App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Validator
{

    private $domains = [];
    private $cacheKey;

    public function refresh()
    {
        $this->cacheKey = config('firelab.domain.cache-key');
        $this->autoUpdate();

        $this->domains = Cache::get($this->cacheKey, []);
        $this->appendCustomDomains();
    }

    protected function autoUpdate()
    {
        $autoUpdate = config('firelab.domain.auto-update');

        if($autoUpdate && !Cache::has($this->cacheKey)) {
            Updater::update();
        }
    }

    protected function appendCustomDomains()
    {
        $appendList = config('firelab.domain.append');
        if(!is_null($appendList)) {
            $appendDomains = explode('|', strtolower($appendList));
            $this->domains = array_merge($this->domains, $appendDomains);
        }
    }

    public function message($message, $attribute, $rule, $parameters)
    {
        return __('The domain for :attribute is not allowed. Please use another email address.', ['attribute' => $attribute]);
    }

    public function validate($attribute, $value, $parameter): bool
    {
        $this->refresh();
        $domain = Str::after(strtolower($value), '@');
        return !in_array($domain, $this->domains);
    }

}