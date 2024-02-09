<?php

namespace FireLab\App\Command;

use FireLab\App\Updater;
use Illuminate\Console\Command;

class BlacklistsUpdateCommand extends Command
{

    protected $signature = 'firelab:update-blacklists';
    protected $description = 'Update cache for FireLab blacklists.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $count = Updater::update();
        if ($count === false) {
            $this->warn('No domains retrieved. Check the email.blacklist.source key for validation config.');
            return;
        }

        if ($count === 0) {
            $this->info('Advice: Blacklist was retrieved from source but 0 domains were listed.');
            return;
        }

        $this->info("{$count} domains retrieved. Cache updated. You are good to go.");
    }

}