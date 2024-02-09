<?php

namespace FireLab\App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Updater
{
    public static function update()
    {
        $url = config('firelab.domain');
        if(is_null($url)){
            return false;
        }
        $key = config('firelab.domain.cache-key', 'firelab.domains.blacklist');
        $duration = Carbon::now()->addMonth();

        $domains = json_decode(file_get_contents($url), true);
        $count = count($domains);

        Cache::put($key, $domains, $duration);
        return $count;
    }

}