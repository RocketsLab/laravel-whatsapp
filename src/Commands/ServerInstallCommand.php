<?php

namespace RocketsLab\LaravelWhatsapp\Commands;

use Illuminate\Console\Command;

class ServerInstallCommand extends Command
{
    protected $signature = 'wa:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install WA server dependencies.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info("Installing server dependencies...");

        $serverPath = __DIR__ . "/../../server";

        exec("cd $serverPath && npm i");

        $this->info("Done. Run php artisan wa:serve to start server.");

    }
}
