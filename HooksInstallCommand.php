<?php

namespace dam1r89\CodeQuality;

use Illuminate\Console\Command;

class HooksInstallCommand extends Command
{
    protected $signature = 'code:install-hooks';

    protected $description = 'Install hooks';

    public function handle()
    {
        $dir = getcwd();
        if (!file_exists("$dir/vendor/bin/php-cs-fixer")) {
            $this->error('You need to instal php cs fixer.');
            $this->error("Run\n\tcomposer require --dev friendsofphp/php-cs-fixer");
        }

        if (!file_exists("$dir/node_modules/eslint/bin/eslint.js")) {
            $this->error('You need to instal eslint.');
            $this->error("Run\n\nnpm i --save-dev eslint");
        }

        file_put_contents($dir.'/.git/hooks/pre-commit', "export PATH=/usr/local/bin:\$PATH\nphp artisan code:lint");
        exec("chmod +x $dir/.git/hooks/pre-commit");
        $this->info('Installed lint on pre commit.');

        $phpCsFixer = $dir.'/.php_cs.dist';
        if (!file_exists($phpCsFixer)) {
            copy(__DIR__.'/stubs/.php_cs.dist', $phpCsFixer);
            $this->info('Instlled .php_cs.dist config file.');
        }

        $esLintRc = $dir.'/.eslintrc.json';
        if (!file_exists($esLintRc)) {
            copy(__DIR__.'/stubs/.eslintrc.json', $esLintRc);
            $this->info('Instlled .eslintrc.json');
        }

        $editorConfig = $dir.'/.editorconfig';
        if (!file_exists($editorConfig)) {
            copy(__DIR__.'/stubs/.editorconfig', $editorConfig);
            $this->info('Instlled .editorconfig');
        }

        $this->info('Done');
    }
}
