<?php

namespace MetaFramework\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aboleon-framework {argument}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the MetaFramework';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (method_exists($this, $this->argument('argument'))) {
            $this->{$this->argument('argument')}();
        } else {
            $this->error("MetaFramework: unknown console command '" . $this->argument('argument') . "'");
        }
    }



    private function config()
    {
        $this->newLine();
        $this->comment('Publishing configuration...');
        $this->comment('------------------------------------------');

        $app_name = $this->ask("What is the name of your app");
        $app_default_lg = $this->ask("What is the app default language locale (en, fr, de..) ? Default is en");

        $file = config_path('app.php');
        $lines = file($file, FILE_IGNORE_NEW_LINES);

        $seek = array_filter($lines, function ($line) {
            return strstr($line, "'name'");
        });
        $lines[key($seek)] = "    'name' => '" . addslashes($app_name) . "',";

        $seek = array_filter($lines, function ($line) {
            return strstr($line, "'locale'");
        });
        $lines[key($seek)] = "    'locale' => '" . $app_default_lg . "',";

        $seek = array_filter($lines, function ($line) {
            return strstr($line, "'fallback_locale'");
        });
        $lines[key($seek)] = "    'fallback_locale' => '" . $app_default_lg . "',";
        file_put_contents($file, implode("\n", $lines));

        $panel_prefix = $this->ask("What is the prefix for your back-office routes");

        file_put_contents(__DIR__ . '/../../publishables/config/aboleon-framework.php', "<?php
return [
    'route' => '" . $panel_prefix . "',
    'locales' => ['" . $app_default_lg . "'],
    'active_locales' => ['" . $app_default_lg . "']
];");

        $this->replaceInFile('/dashboard', '/' . $panel_prefix . '/dashboard', app_path('Providers/RouteServiceProvider.php'));


        $this->callPublishConfiguration();
    }



}