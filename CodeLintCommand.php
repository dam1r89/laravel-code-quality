<?php

namespace dam1r89\CodeQuality;

use Illuminate\Console\Command;

class CodeLintCommand extends Command
{
    protected $signature = 'code:lint';

    protected $description = 'Lint the code';

    public function handle()
    {
        exec('git diff --name-only --cached --diff-filter=ACMRTUXB | xargs php ./vendor/bin/php-cs-fixer fix -v --dry-run --stop-on-violation --path-mode=intersection --config=.php_cs.dist  --using-cache=no', $out, $status);

        foreach ($out as $line) {
            echo $line."\n";
        }

        exec('./vendor/bin/phpunit', $out, $status2);

        foreach ($out as $line) {
            echo $line."\n";
        }

        exec("./node_modules/eslint/bin/eslint.js `git diff --name-only --cached --diff-filter=AM HEAD | grep '^resources/assets/js.*\.\(vue\|js\)\$'`", $out, $status3);

        foreach ($out as $line) {
            echo $line."\n";
        }

        $output = $status || $status2 || $status3;
        if ($output) {
            $this->error('Not successful');
        } else {
            $this->info('Lint successful');
        }

        return (int) $output;
    }
}
