<?php

namespace RocketsLab\LaravelWhatsapp\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;

class WACommand extends Command
{
    protected $signature = 'wa:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts WhatsApp server.';

    public function __construct()
    {
        parent::__construct();

        $this->specifyParameters();
    }

    protected function getOptions()
    {
        return array_merge([
            ['host', null, InputOption::VALUE_OPTIONAL, '', config('laravel_whatsapp.host')],
            ['port', null, InputOption::VALUE_OPTIONAL, '', config('laravel_whatsapp.port')],
        ], parent::getOptions());
    }

    public function handle()
    {
        $protocol = config('laravel_whatsapp.protocol');

        $host = $this->option("host");

        $port = $this->option("port");

        $this->info("Starting whatsapp node server...");

        $serverPath = __DIR__ . "/../../server";

        $output = new ConsoleOutput();

        exec("node $serverPath $protocol $host $port", $output);
    }
}
