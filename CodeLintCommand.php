<?php

namespace dam1r89\CodeQuality;

use Illuminate\Console\Command;

class CodeLintCommand extends Command
{
    protected $signature = 'code:lint {--skip-eslint} {--skip-phpunit} {--skip-cs}';

    protected $description = 'Lint the code';

    public function handle()
    {
        if (!$this->option('skip-cs')) {
            passthru('git diff --name-only --cached --diff-filter=ACMRTUXB | xargs php ./vendor/bin/php-cs-fixer fix -v --dry-run --stop-on-violation --path-mode=intersection --config=.php_cs.dist  --using-cache=no', $status);
        }

        if (!$this->option('skip-phpunit')) {
            passthru('./vendor/bin/phpunit --stop-on-failure', $status2);
        }

        if (!$this->option('skip-eslint')) {
            passthru("./node_modules/eslint/bin/eslint.js `git diff --name-only --cached --diff-filter=AM HEAD | grep '^resources/assets/js.*\.\(vue\|js\)\$'`", $status3);
        }
        $output = ($status ?? 0) || ($status2 ?? 0) || ($status3 ?? 0);
        if ($output) {
            $this->error('Not successful');
        } else {
            $this->info('Lint successful');
        }

        return (int) $output;
    }
}
